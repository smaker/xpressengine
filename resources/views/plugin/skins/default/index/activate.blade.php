<form action="{{ route('settings.plugins.manage.activate') }}" method="post">
    {{ csrf_field() }}

    <div class="xe-modal-header">
        <button type="button" class="btn-close" data-dismiss="xe-modal" aria-label="Close"><i class="xi-close"></i></button>
        <strong class="xe-modal-title">{{ xe_trans('xe::plugin') }} {{ xe_trans('xe::activate') }}</strong>
    </div>
    <div class="xe-modal-body">

        <p>
            아래 플러그인을 활성화시키겠습니까?
        </p>

        <hr>

        <ul>
            @foreach($plugins as $plugin)

                <li>
                    {{ $plugin->getTitle() }}({{ $plugin->getId() }})
                    @if($plugin->isActivated())
                     - 이미 활성화되어 있음
                    @else
                        <input type="hidden" name="pluginId[]" value="{{ $plugin->getId() }}">
                    @endif
                </li>

            @endforeach
        </ul>

    </div>
    <div class="xe-modal-footer">
        <button type="button" class="xe-btn xe-btn-secondary" data-dismiss="xe-modal">{{ xe_trans('xe::cancel') }}</button>
        <button type="submit" class="xe-btn xe-btn-primary" >{{ xe_trans('xe::activate') }}</button>
    </div>
</form>








