@section('title')
    <title>{{$title}}</title>
@endsection

@section('name')
    <h4 class="page-title">{{$title}}</h4>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section($title)
    class="mm-active"
@endsection
