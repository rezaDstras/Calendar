@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div id="app" class="card-body">
                    <Register-form ></Register-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    import RegisterForm from "../../js/components/user/RegisterForm";
    export default {
        components: {RegisterForm}
    }
</script>
