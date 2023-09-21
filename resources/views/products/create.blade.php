@extends('layout') <!-- Assuming you have a layout file, adjust as needed -->

@section('content')
<div class="container">
    <h2>Add a New Product</h2>
    <form id='productForm' method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf <!-- CSRF token -->

        <!-- Product Name -->
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required min="0" step="0.01">
            @if ($errors->has('price'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('price') }}</strong>
                </span>
            @endif
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
            @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>

        <!-- Image Upload -->
        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" name="image" id="image" class="form-control-file">
            @if ($errors->has('image'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('image') }}</strong>
                </span>
            @endif
        </div>

         <!-- Thumb Upload -->
         <div class="form-group">
            <label for="image">Product Thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail" class="form-control-file">
            @if ($errors->has('thumbnail'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('thumbnail') }}</strong>
                </span>
            @endif
        </div>

        <!-- Quantity -->
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', 0) }}" required min="0">
            @if ($errors->has('quantity'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('quantity') }}</strong>
                </span>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Product</button>
        </div>
    </form>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#productForm').submit(function(event) {
                event.preventDefault();

                // Send a POST request to the server
                $.ajax({
                    type: 'POST',
                    url: this.action, // Replace with your server-side script URL
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success("Record Updated", response.message);
                        $('#productForm')[0].reset();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        toastr.error("Somthing went wrong", response.message);
                    }
                });
            });
        });
    </script>
@endsection

