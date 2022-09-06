<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, ShouldAutoSize, WithHeadings
{

    private $search_query;
    private $gender_id;
    private $start;
    private $end;
    private $date_of_birth;

    public function __construct($request)
    {
        if (isset($request->search_query)) {
            $this->search_query = $request->search_query;
        }

        if (isset($request->gender_id)) {
            $this->gender_id = $request->gender_id;
        }

        if (isset($request->start)) {
            $this->start = $request->start;
        }

        if (isset($request->end)) {
            $this->end = $request->end;
        }

        if (isset($request->date_of_birth)) {
            $this->date_of_birth = $request->date_of_birth;
        }

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = User::where('is_admin', 1);

        if (isset($this->search_query) && !empty($this->search_query)) {
            $query = $query->where(function ($query) {
                $query->orWhere('name', 'LIKE', "%{$this->search_query}%");
                $query->orWhere('phone', 'LIKE', "%{$this->search_query}%");
                $query->orWhere('email', 'LIKE', "%{$this->search_query}%");
            });
        }

        if (isset($this->gender_id) && (!empty($this->gender_id) || strlen($this->gender_id) > 0)) {
            $query = $query->where('gender_id', $this->gender_id);
        }

        if (isset($this->start) && !empty($this->start)) {
            $query = $query->whereDate('created_at', '>=', $this->start);
        }

        if (isset($this->end) && !empty($this->end)) {
            $query = $query->whereDate('created_at', '<=', $this->end);
        }

        if (isset($this->date_of_birth) && !empty($this->date_of_birth)) {
            $query = $query->whereMonth('date_of_birth', now()->month)->whereDay('date_of_birth', now()->day)->where('is_admin', 0);
        }

        $items = $query->latest()->get();

        $itemsExport = [];

        foreach ($items as $index => $item) {

            $itemTemp = [
                ($index + 1),
                $item->id,
                optional($item->role)->name,
                $item->name,
                $item->phone,
                $item->date_of_birth,
                optional($item->gender)->name,
                $item->created_at,
            ];
            $itemsExport[] = $itemTemp;
        }

        return collect($itemsExport);
    }

    public function headings(): array
    {
        $headings = [
            ['STT', 'Mã NV', 'Vai trò', 'Tên KH', 'Số điện thoại', 'Ngày sinh', 'Giới tính', 'Ngày sử dụng']
        ];

        return $headings;
    }

}
