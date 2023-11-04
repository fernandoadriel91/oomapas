<div class="d-flex align-items-center">
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator" @if(isset($data) && isset($data['breadcrumbs']) && count($data['breadcrumbs']) > 1)style="border-right: 1px solid #cbced4;"@endif>
            {{$data['title']}}
        </h3>
        @if(isset($data) && isset($data['breadcrumbs']) && count($data['breadcrumbs']) > 1)
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="javascript:void(0)" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon la la-home"></i>
                </a>
            </li>
            @foreach ($data['breadcrumbs'] as $crumb)
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="javascript:void(0)" class="m-nav__link">
                    <span class="m-nav__link-text">
                        {{$crumb['breadcrumb']}}
                    </span>
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
</div>