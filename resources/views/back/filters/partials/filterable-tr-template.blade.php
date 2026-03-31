<script id="filterable-tr-template" type="text/x-custom-template">
    <tr id="spec-tr">
        <td class="text-center draggable-handler ui-sortable-handle">
            <div class="fonticon-wrap"><i class="feather icon-move"></i></div>
        </td>
        <td class="text-center"><span id="filterable-name"></span> <small id="filterable-title" class="text-warning"></small></td>
        <td class="text-center">
            <div class="custom-control custom-switch custom-control-inline m-0">
                <input type="checkbox" class="custom-control-input" id="customSwitch" checked>
                <label class="custom-control-label" for="customSwitch">
                </label>
            </div>
        </td>
        <td class="text-center">
            <div id="specification-options">
                <input type="text" id="separator" class="form-control" placeholder="جداکننده">
            </div>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-danger waves-effect waves-light remove-filter">حذف</button>
        </td>
        <input type="hidden" id="type">
        <input id="filterableId" type="hidden">
    </tr>
</script>