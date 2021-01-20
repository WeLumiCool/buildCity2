<div class="row justify-content-center">
    <a class="btn btn-success ml-1" href="{{ route('admin.' . $type . '.show', $model) }}"><i
                class="fas fa-eye"></i></a>
</div>

<script>
    function deleteConfirm(me) {
        if (confirm('Вы дествительно хотите удалить ?')) {
            let model_id = me.dataset.id;
            $('form#form-' + model_id).submit();
        }
    }
</script>
