@extends('layout.default-common')

@section('style')
{{ HTML::style( asset('css/pago-tarjeta.css'))}}
@stop

@section('script')
{{ HTML::script( asset('js/pago-tarjeta.js')) }}
@stop


@section('home')
<div class="col-md-3"></div>
<div class="col-md-6">
@include('formulario-tarjeta')
</div>
<div class="col-md-3"></div>
@stop

@section('aseguros')
@include('aseguros')
@stop

@section('banner')
<div id="banner-background" style="background-image: url({{ asset('images/banner.png') }}); text-align: center; padding: 7.5em 0 7.5em 0;">
	<p class="gidole" style="font-size: 2.5vw; color: #FFFFFF; margin: 0; ">COTIZAMOS EL MEJOR SEGURO PARA TI...</p>
</div>
@stop

@section('modals')
@include('modals')
@stop
