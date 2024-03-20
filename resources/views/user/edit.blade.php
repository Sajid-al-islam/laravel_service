@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-8 m-auto mt-5">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    {{ Session::get('success') }}
                    @php
                        Session::forget('success');
                    @endphp
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible text-white">
                    <ul class="text-white">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            <div class="card multisteps-form__panel p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                <h5 class="font-weight-bolder mb-0">Edit user</h5>
                <div class="multisteps-form__content">
                    <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mt-3">
                            <div class="col-12 col-sm-12">
                                <label>Name</label>
                                <input name="name" value="{{ $user->name }}" class="multisteps-form__input form-control" type="text" placeholder="eg. Michael" onfocus="focused(this)" onfocusout="defocused(this)" required/>
                            </div>
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>Phone Number</label>
                                <input name="phone_number" value="{{ $user->phone_number }}" class="multisteps-form__input form-control" type="text" placeholder="eg. Prior" onfocus="focused(this)" onfocusout="defocused(this)" required/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <label>Email Address</label>
                                <input
                                    name="email"
                                    value="{{ $user->email }}"
                                    class="multisteps-form__input form-control"
                                    type="email"
                                    placeholder="eg. soft@dashboard.com"
                                    onfocus="focused(this)"
                                    onfocusout="defocused(this)"
                                    data-temp-mail-org="0"
                                    required
                                />
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-sm-6">
                                <label>Password</label>
                                <input name="password" class="multisteps-form__input form-control" type="password" placeholder="******" onfocus="focused(this)" onfocusout="defocused(this)"/>
                            </div>
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <label>Repeat Password</label>
                                <input name="password_confirmation" class="multisteps-form__input form-control" type="password" placeholder="******" onfocus="focused(this)" onfocusout="defocused(this)" />
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                <img src="{{ Storage::url($user->photo) }}" alt="img_not_found" class="my-3 img-fluid img-thumbnail" width="100" height="80"><br>
                                <label>Image</label>
                                <input name="photo" class="multisteps-form__input form-control" type="file" onfocus="focused(this)" onfocusout="defocused(this)" accept="image/*" />
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                                <h5 class="font-weight-bolder mb-2">Addresses</h5>
                                <div id="addressFields" class="row">
                                    @forelse ($user->addresses as $index => $address)
                                        <div class="addressField col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="text" name="addresses[{{ $index }}][address]" placeholder="Address Line 1" value="{{ $address->address }}" class="form-control mb-2">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="addresses[{{ $index }}][city]" placeholder="City" value="{{ $address->city }}" class="form-control">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="addresses[{{ $index }}][state]" placeholder="State" value="{{ $address->state }}" class="form-control">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="addresses[{{ $index }}][zip_code]" placeholder="Zip Code" value="{{ $address->zip_code }}" class="form-control">
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <button type="button" class="deleteAddressField btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="addressField col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="text" name="addresses[0][address]" placeholder="Address Line 1" class="form-control mb-2">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="addresses[0][city]" placeholder="City" class="form-control">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="addresses[0][state]" placeholder="State" class="form-control">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="addresses[0][zip_code]" placeholder="Zip Code" class="form-control">
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <button type="button" class="deleteAddressField btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                <button type="button" id="addAddressField" class="btn bg-gradient-secondary ms-auto mt-3">Add Address</button>
                            </div>
                        </div>

                        <div class="button-row d-flex mt-4">
                            <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        const addressFieldsContainer = document.getElementById('addressFields');
        const addAddressFieldBtn = document.getElementById('addAddressField');

        let addressFieldIndex = 1;

        addAddressFieldBtn.addEventListener('click', () => {
            const newIndex = document.querySelectorAll('.addressField').length;
            const newAddressField = document.createElement('div');
            newAddressField.classList.add('addressField', 'col-12', 'col-md-6');
            newAddressField.innerHTML = `
                <div class="row">
                    <div class="col-12">
                        <input type="text" name="addresses[${newIndex}][address]" placeholder="Address Line 1" class="form-control mb-2">
                    </div>
                    <div class="col-4">
                        <input type="text" name="addresses[${newIndex}][city]" placeholder="City" class="form-control">
                    </div>
                    <div class="col-4">
                        <input type="text" name="addresses[${newIndex}][state]" placeholder="State" class="form-control">
                    </div>
                    <div class="col-4">
                        <input type="text" name="addresses[${newIndex}][zip_code]" placeholder="Zip Code" class="form-control">
                    </div>
                    <div class="col-12 mt-2">
                        <button type="button" class="deleteAddressField btn btn-danger">Delete</button>
                    </div>
                </div>
            `;
            addressFieldsContainer.appendChild(newAddressField);
            addDeleteAddressFieldListeners();
        });

        function addDeleteAddressFieldListeners() {
            const deleteAddressFieldBtns = document.querySelectorAll('.deleteAddressField');
            deleteAddressFieldBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const addressField = btn.parentNode.parentNode.parentNode;
                    addressFieldsContainer.removeChild(addressField);
                });
            });
        }

        addDeleteAddressFieldListeners();
    </script>
@endsection
