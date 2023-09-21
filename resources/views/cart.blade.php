@extends('layout')

@section('content')
<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:20%">Quantity</th>
            <th style="width:10%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0 @endphp
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <tr id='{{'cart_'.$id }}' data-id="{{ $id }}">
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ $details['image'] }}" width="100" height="100" class="img-responsive"/></div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">${{ $details['price'] }}</td>
                    <td data-th="Quantity" >
                        <div class="product-info-qty-item">
                            <button class="product-info-qty product-info-qty-minus" >-</button>

                            <input value="{{ $details['quantity'] }}" class="product-info-qty product-info-qty-input quantity update-cart" min="1" max="995" type="number">

                            <button class="product-info-qty product-info-qty-plus">+</button>
                        </div>

                    </td>
                    <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
                    <td class="actions" data-th="">
                        <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right"><h3><strong>Total ${{ $total }}</strong></h3></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                <button class="btn btn-success">Checkout</button>
            </td>
        </tr>
    </tfoot>
</table>
@endsection

@section('scripts')
<script type="text/javascript">
    $(".product-info-qty-plus").click(function (e) {
        var ele = $(this);
        var val = ele.parents("tr").find(".quantity").val()
        ele.parents("tr").find(".quantity").val(parseInt(val)+1)
        ajaxReq(ele)
    })
    $(".product-info-qty-minus").click(function (e) {
        var ele = $(this);
        var val = ele.parents("tr").find(".quantity").val()
        if(val>1){
            ele.parents("tr").find(".quantity").val(val-1)
            ajaxReq(ele)
        }
    })

    $(".update-cart").change(function (e) {
        e.preventDefault();

        var ele = $(this);
        ajaxReq(ele)
    });
    function ajaxReq(ele) {
        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find("td > div > .quantity").val()
            },
            success: function (response) {
                if(response.success){
                    toastr.success("Record Updated", response.message);
                }else{
                    toastr.error("Somthing went wrong", response.message);
                }
            }
        });
    }

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();

        var ele = $(this);

        if(confirm("Are you sure want to remove?")) {
            var cartId= ele.parents("tr").attr("data-id");
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: cartId
                },
                success: function (response) {
                    if(response.success){
                        toastr.success("Record Updated", response.message);
                    }else{
                        toastr.error("Somthing went wrong", response.message);
                    }
                    $('#'.cartId).remove();
                    // window.location.reload()
                }
            });
        }
    });

</script>
@endsection
