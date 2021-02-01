<div class="row justify-content-center">
    <a class="btn btn-success ml-1" href="{{ route('admin.' . $type . '.show', $model) }}"><i

                class="fas fa-eye"></i></a>

            </a>
    @if($model->is_active == false)
        <form id="form-{{ $model->id }}" name="delete-form" method="POST"
              action="{{ route('admin.'.$type.'.destroy', $model) }}">
            @csrf
            @method('DELETE')
            <button type="button" onclick="deleteConfirm(this)" data-id="{{ $model->id }}" title="{{ __('Удалить') }}"
                    class="btn n btn-danger ml-1">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    @endif
    <a class="btn btn-primary ml-1" href="{{ route('admin.'.$type.'.edit', $model) }}" ><i class="fas fa-pen"></i></a>

</div>


<script>
    function deleteConfirm(me) {
        if (confirm('Вы дествительно хотите удалить ?')) {
            let model_id = me.dataset.id;
            $('form#form-' + model_id).submit();
        }
    }
</script>
