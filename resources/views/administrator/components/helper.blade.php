<script>

    let input_query_from, input_query_to

    @if(!empty(request('from')))
        input_query_from = "{{request('from')}}"
    @endif

        @if(!empty(request('to')))
        input_query_to = "{{request('to')}}"
    @endif

    $(document).ready(function () {
        $('.open-jquery-date').flatpickr({
            mode: "range",
            dateFormat: "{{config('_my_config.type_date')}}",
            onClose: function (selectedDates, dateStr, instance) {
                var dateStart = instance.formatDate(selectedDates[0], "{{config('_my_config.type_date')}}");
                var dateEnd = instance.formatDate(selectedDates[1], "{{config('_my_config.type_date')}}");

                input_query_from = dateStart
                input_query_to = dateEnd
            },
            @if(!empty(request('from')) && !empty(request('to')))
            defaultDate: ["{{request('from')}}", "{{request('to')}}"]
            @endif

        });
    });

    $("#input_search_query").on("keydown", function search(e) {
        if (e.keyCode == 13) {
            onSearchQuery()
        }
    });

    function onSearchQuery() {
        addUrlParameterObjects([
            {name: "search_query", value: $('#input_search_query').val()},
            {name: "from", value: input_query_from},
            {name: "to", value: input_query_to},
        ])
    }


</script>
