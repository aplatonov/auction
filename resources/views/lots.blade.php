@extends('layouts.lot')

@section('content')
    @if (Auth::user()['original']['confirmed'] == 1)
        <div class="post-summary-footer align-right">
            <span class="right">
                <strong>Здравствуйте, {{ Auth::user()->username }}!</strong><br>
                <strong>Ваши ставки (победы): </strong>34 (12)<br>
                <strong>Всего: </strong><i class="icon-shopping-cart"></i> 23, <i class="icon-user"></i> 99</br>
            </span>
        </div>
    @endif
@endsection
