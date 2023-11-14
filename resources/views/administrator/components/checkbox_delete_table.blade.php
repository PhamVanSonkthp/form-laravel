<button id="btn_delete_checkbox_item" onclick="onDeleteItemByCheckbox()" type="button" style="display: none;position: unset;
    width: 35px;
    background: red;
    color: white;
    border: aliceblue;
    padding-top: 5px;
    padding-bottom: 5px;
    border-radius: 20px;">
    <i class="fa-solid fa-x"></i>
</button>

<script>
    function onSelectCheckboxDeleteItem(){
        let is_checked = $('#check_box_delete_all').is(":checked")
        $('.checkbox-delete-item').prop('checked', is_checked)
        showButtonDeleteCheckbox(is_checked)
    }

    function showButtonDeleteCheckbox(is_checked){

        if (is_checked){
            $('#btn_delete_checkbox_item').show()
        }else{
            $('#btn_delete_checkbox_item').hide()
        }
    }

    function onDeleteItemByCheckbox(){
        if (confirm("Xác nhận xóa") == true) {

            let ids = []

            $(".checkbox-delete-item:checked").each(function(){
                if ($(this).val()){
                    ids.push($(this).val());
                }
            });

            if (!ids.length){
                alert("Bạn chưa chọn hàng nào")
                return;
            }

            callAjax(
                "DELETE",
                "{{route('administrator.'.$prefixView.'.delete_many')}}",
                {
                    ids: ids,
                },
                (response) => {
                    window.location.reload()
                },
                (error) => {

                }
            )

        }
    }


    $(document).ready(function() {
        $('.checkbox-delete-item').change(function(){
            let is_checked = false;

            $(".checkbox-delete-item:checked").each(function(){
                is_checked = true;
            });

            $('#check_box_delete_all').prop('checked', is_checked)
            showButtonDeleteCheckbox(is_checked)

        });
    });

</script>
