@if (auth()->user()->user_type == 'member')
    @if ($notifications->count() > 0)
        @foreach ($notifications as $key => $notification)
            @php
                $check = 'done';
                $notify_data = json_decode($notification->data);
                $user_data = \App\Models\User::where('id', $notify_data->notify_by)->first();
            @endphp
            @if ($notify_data->type == 'express_interest')
                @php
                    $interest_data = App\Models\ExpressInterest::where('id', $notify_data->info_id)->first();
                    if (empty($interest_data)) {
                        $check = 'not_done';
                    }
                @endphp
            @endif
            @if ($check == 'done' && !empty($user_data))
                <li class="list-group-item p-3 hov-bg-soft-primary border-bottom">
                    <a href="{{ route('notification_view', $notification->id) }}" class="d-flex align-items-center text-inherit w-100 text-decoration-none">
                        <span class="avatar avatar-sm mr-3 flex-shrink-0">
                            @php
                                $avatar_image = $user_data->member->gender == 1 ? 'assets/img/avatar-place.png' : 'assets/img/female-avatar-place.png';
                                $profile_picture_show = show_profile_picture($user_data);
                            @endphp
                            <img @if ($profile_picture_show) src="{{ uploaded_asset($user_data->photo) }}"
                            @else
                            src="{{ static_asset($avatar_image) }}" @endif
                                class="rounded-circle"
                                style="width:40px;height:40px;object-fit:cover;"
                                onerror="this.onerror=null;this.src='{{ static_asset($avatar_image) }}';">
                        </span>
                        <div class="flex-grow-1 minw-0 pr-2">
                            <h6 class="mb-1 fs-13 font-weight-bold text-dark text-truncate">{{ $user_data->first_name . ' ' . $user_data->last_name }}</h6>
                            <p class="mb-0 fs-12 text-muted text-wrap" style="line-height:1.4;word-break:break-word;">
                                {{ $notify_data->message }}
                            </p>
                        </div>
                        @if ($notification->read_at == null)
                            <span class="badge badge-dot badge-circle badge-primary flex-shrink-0 ml-auto" style="width:8px;height:8px;"></span>
                        @endif
                    </a>
                </li>
            @endif
        @endforeach
    @else
        <li class="list-group-item">
            <div class="text-center">
                <i class="las la-frown la-4x mb-4 opacity-40"></i>
                <h4 class="h5">{{ translate('No Notifications') }}</h4>
            </div>
        </li>
    @endif
@endif
