<li>
    <img src="{{ data_get($plugin, 'icon') }}" alt="">
    <div class="list-install-caption">
        <label class="xe-label" style="display: inline">
            <input type="checkbox" @if($handler->getPlugin(data_get($plugin, 'plugin_id'))) disabled @else value="{{ data_get($plugin, 'plugin_id') }}" class="__xe_checkbox"
                data-title="{{ data_get($plugin, 'title') }}" data-id="{{ data_get($plugin, 'plugin_id') }}" @endif
               @if(!data_get($plugin, 'is_free') && !data_get($plugin, 'is_purchased')) data-need-purchase="true" @endif
            >
            <span class="xe-input-helper"></span>
        </label>
        <a href="{{ data_get($plugin, 'link') }}" target="_blank"><span class="xe-label-text">{{ data_get($plugin, 'title') }}</span></a>
        <div class="list-install-caption-bottom">
            <p class="list-install-text">Version {{ data_get($plugin, 'latest_release.version') }}</p>
            <p class="list-install-text">
                @if(data_get($plugin, 'is_free'))
                    Free
                @else
                    ￦{{ number_format(data_get($plugin, 'price')) }}
                @endif
            <p class="list-install-text">
                @if($handler->getPlugin(data_get($plugin, 'plugin_id')))
                    {{ xe_trans('xe::installed') }}
                @else
                    {{ xe_trans('xe::notInstalledYet') }}
                @endif

                @if(data_get($plugin, 'is_purchased'))
                    ({{ xe_trans('xe::purchasedPlugins') }})
                @elseif(data_get($plugin, 'is_free') === false)
                    <a href="{{ data_get($plugin, 'link') }}" class="btn-link" target="_blank">{{ xe_trans('xe::goToBuy') }}</a>
                @endif
            </p>
        </div>
    </div>
</li>
