<div class="row gidole">
    <div class="bkng-tb-cntnt">
        <div class="pymnts">
            {{ Form::open(['action' => 'QuoteController@cargoTarjeta', 'method' => 'POST', 'id' => 'payment-form']) }}
                <input type="hidden" name="token_id" id="token_id">
                @foreach(Input::all() as $clave => $value)
                    @if($clave != '_token')
                        <input type="hidden" name="{{$clave}}" value="{{$value}}">
                    @endif
                @endforeach
                <div class="pymnt-itm card active">
                    <h2>Tarjeta de crédito o débito</h2>
                    <div class="pymnt-cntnt">
                        <div class="card-expl">
                            <div class="credit"><h4>Tarjetas de crédito</h4></div>
                            <div class="debit"><h4>Tarjetas de débito</h4></div>
                        </div>
                        <div class="sctn-row">
                            <div class="sctn-col l">
                                <label>Nombre del titular</label><input type="text" name="holder_name" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name">
                            </div>
                            <div class="sctn-col">
                                <label>Número de tarjeta</label><input type="text" name="card_number" autocomplete="off" data-openpay-card="card_number"></div>
                            </div>
                            <div class="sctn-row">
                                <div class="sctn-col l">
                                    <label>Fecha de expiración</label>
                                    <div class="sctn-col half l"><input type="text" name="expiration_month" placeholder="Mes" data-openpay-card="expiration_month"></div>
                                    <div class="sctn-col half l"><input type="text" name="expiration_year" placeholder="Año" data-openpay-card="expiration_year"></div>
                                </div>
                                <div class="sctn-col cvv"><label>Código de seguridad</label>
                                    <div class="sctn-col half l"><input type="text" name="cvv2" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2"></div>
                                </div>
                            </div>
                            <div class="openpay"><div class="logo">Transacciones realizadas vía:</div>
                            <div class="shield">Tus pagos se realizan de forma segura con encriptación de 256 bits</div>
                        </div>
                        <div class="sctn-row">
                                <a class="button rght" id="pay-button">Pagar</a>
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>