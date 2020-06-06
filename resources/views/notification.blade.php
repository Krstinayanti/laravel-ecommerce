@extends('layouts.user')

@section('title') Home @endsection

@section('content')

<section class="">
<div class="container">

		<div class="container">
			<div class="card mb-5">
        <div class="card-body">
          <h3 class="title mb-3"><i class="fa fa-bell"></i> Notifikasi ({{ $user->unreadNotifications->count() }})</h3>
          @foreach($user->unreadNotifications as $notification)
            @switch($notification->type)
                @case('App\Notifications\StatusTransaction')
                        <div class="card mb-3">
                            <div class="card-body">
                                <span>Nama Barang: <b>{{ $notification->data['data']['product_name'] }}</b></span>
                                <span class="text-muted d-block">{{ $notification->data['data']['status'] }}</span>
                                <span><small><i class="fa fa-clock-o"></i> {{ $notification->created_at->diffForHumans() }}</small></span>
                            </div>
                        </div>
                    @break
                @case('App\Notifications\ReviewProductUser')
                        <div class="card mb-3">
                            <div class="card-body">
                                <span class="text-muted d-block">{{ $notification->data['data'] }}</span>
                                <span><small><i class="fa fa-clock-o"></i> {{ $notification->created_at->diffForHumans() }}</small></span>
                            </div>
                        </div>
                    @break
                @default

            @endswitch
          @endforeach
        </div>
       </div>
	 </div>

</div>


    </div>
</section>
<!-- Display the countdown timer in an element -->
@endsection
