@extends('admin.layouts.app', [
    'pageName' => __('trans.sales'),
])

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.sales_create')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.sales.store') }}" id="main-form">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="client_id">@lang('trans.client')</label>
                                    <select
                                        name="client_id"
                                        id="client_id"
                                        class="form-control select2 @error('client_id') is-invalid @enderror">
                                        <option value="">@lang('trans.choose')</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="sale_date">@lang('trans.date')</label>
                                    <input
                                        type="text"
                                        class="form-control datepicker @error('sale_date') is-invalid @enderror"
                                        id="sale_date"
                                        placeholder="@lang('trans.date')"
                                        name="sale_date">
                                    @error('sale_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="invoice_number">@lang('trans.invoice_number')</label>
                                    <input
                                        type="text"
                                        class="form-control @error('invoice_number') is-invalid @enderror"
                                        id="invoice_number"
                                        placeholder="@lang('trans.invoice_number')"
                                        name="invoice_number">
                                    @error('invoice_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="safe_id">@lang('trans.safe')</label>
                                    <select
                                        name="safe_id"
                                        id="safe_id"
                                        class="form-control select2 @error('safe_id') is-invalid @enderror">
                                        @foreach($safes as $safe)
                                            <option value="{{ $safe->id }}">{{ $safe->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('safe_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="item_id">@lang('trans.item')</label>
                                    <select
                                        id="item_id"
                                        class="form-control select2">
                                        <option value="">@lang('trans.choose')</option>
                                        @foreach($items as $item)
                                            <option
                                                data-price="{{$item->price}}"
                                                data-quantity="{{$item->quantity}}"
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="qty">@lang('trans.qty')</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="qty"
                                        placeholder="@lang('trans.qty')">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="notes">@lang('trans.notes')</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="notes"
                                        placeholder="@lang('trans.notes')">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <button
                                    type="button"
                                    id="add_item"
                                    class="btn btn-primary mb-2 btn-block"
                                    style="margin-top: 32px">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" style="width: 40px">#</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th style="width: 120px">Qnt</th>
                                    <th style="width: 100px">Total</th>
                                    <th>Notes</th>
                                    <th></th>
                                </tr>
                                <tbody id="items_list">

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total</th>
                                    <th id="total_price">0</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Discount</th>
                                    <th id="discount">0</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Net</th>
                                    <th id="net">0</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="discount-box">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>@lang('trans.discount_type')</label>
                                    @foreach($discountTypes as $discountTypeVal => $discountType)
                                        <div class="form-check">
                                            <input class="form-check-input" id="discount{{$discountTypeVal}}" type="radio" name="discount_type"
                                                   value="{{ $discountTypeVal }}"
                                                   @if($loop->first) checked @endif>
                                            <label for="discount{{$discountTypeVal}}" class="form-check-label">{{ $discountType }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="notes">@lang('trans.discount_value')</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="discount_value"
                                            placeholder="@lang('trans.discount_value')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <x-form-submit text="Create"></x-form-submit>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection


@push('js')
    <script>
        var counter = 1
        var totalPrice = 0;
        $("#add_item").on('click', function (e) {
            e.preventDefault();
            let item = $("#item_id");
            let itemID = item.val();
            let selectedItem = $("#item_id option:selected");
            let itemName = selectedItem.text()
            let itemPrice = selectedItem.data('price');
            let qnt = $("#qty")
            var itemQty = qnt.val();
            let notes = $("#notes")
            let itemNotes = notes.val();
            let itemTotal = itemPrice * itemQty;

            // validate inputs : item chosen , qnt , qnt > 0 , qnt <= available qnt
            if (!itemID) {
                // sweelalet error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please choose an item',
                })
                return;
            }
            if (!itemQty || itemQty <= 0 || itemQty > selectedItem.data('quantity')) {
                // sweelalet error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter a valid quantity',
                })
                return;
            }

            $("#items_list").append('' +
                '<tr>' +
                '<td>' + counter + '</td>' +
                '<td><span>' + itemName + '</span><input type="hidden" name="items[0][id]" value="'+itemID+'">' +
                '</td>' +
                '<td>' + itemPrice +
                '</td>' +
                '<td><input type="number" class="form-control" name="items[0][qty]" value="'+itemQty+'">' +
                '</td>' +
                '<td>' + itemTotal + '</td>' +
                '<td>' + itemNotes + '<input type="hidden" name="items[0][notes]">' +
                '</td>' +
                '<td><button type="button" class="btn btn-danger btn-sm deleteItem"><i class="fa fa-trash"></i></button></td>' +
                '</tr>');
            counter++

            totalPrice += itemTotal;
            totalPrice = Math.round((totalPrice + Number.EPSILON) * 100) / 100;
            $("#total_price").text(totalPrice);

            calculateDiscount()


            item.val("").trigger('change')
            qnt.val("")
            notes.val("")
        })

        $("#discount_value").on('keyup', function (e){
            e.preventDefault()
            calculateDiscount()
        })
        $('input[name="discount_type"]').on('change', function (e){
            e.preventDefault()
            calculateDiscount()
        })



        $(document).on('click', '.deleteItem', function (e) {
            // get the total of the item in the same row
            let itemTotal = $(this).closest('tr').find('td:nth-child(5)').text();
            totalPrice -= itemTotal;
            totalPrice = Math.round((totalPrice + Number.EPSILON) * 100) / 100;
            $("#total_price").text(totalPrice);
            calculateDiscount()
            $(this).closest('tr').remove();
        })


        function calculateDiscount(){
            let discount = 0;
            // get discount type using input name
            let discountType = $('input[name="discount_type"]:checked').val();
            if (discountType === '{{ \App\Enums\DiscountTypeEnum::fixed->value }}') {
                discount = parseFloat($("#discount_value").val() || 0);
            } else {
                let discountPercent = parseFloat($("#discount_value").val() || 0);
                discount = (totalPrice * discountPercent) / 100;
                // round to 2 decimal places
                discount = Math.round((discount + Number.EPSILON) * 100) / 100;
            }
            let net = totalPrice - discount;
            net = Math.round((net + Number.EPSILON) * 100) / 100;
            $("#discount").text(discount);
            $("#net").text(net);
        }
    </script>
@endpush
