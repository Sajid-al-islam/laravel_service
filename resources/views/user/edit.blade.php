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
                                <h3>Addresses</h3>
                                <div id="addressFields">
                                    @forelse ($user->addresses as $index => $address)
                                        <div class="addressField">
                                            <input type="text" name="addresses[{{ $index }}][address]" placeholder="Address Line 1" value="{{ $address->address_line_1 }}">
                                            <input type="text" name="addresses[{{ $index }}][city]" placeholder="City" value="{{ $address->city }}">
                                            <input type="text" name="addresses[{{ $index }}][state]" placeholder="State" value="{{ $address->state }}">
                                            <input type="text" name="addresses[{{ $index }}][zip_code]" placeholder="Zip Code" value="{{ $address->zip_code }}">
                                            <button type="button" class="deleteAddressField">Delete</button>
                                        </div>
                                    @empty
                                        <div class="addressField">
                                            <input type="text" name="addresses[0][address]" placeholder="Address Line 1">
                                            <input type="text" name="addresses[0][city]" placeholder="City">
                                            <input type="text" name="addresses[0][state]" placeholder="State">
                                            <input type="text" name="addresses[0][zip_code]" placeholder="Zip Code">
                                            <button type="button" class="deleteAddressField">Delete</button>
                                        </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn bg-gradient-secondary ms-auto" id="addAddressField">Add Address</button>
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
            const newAddressField = document.createElement('div');
            newAddressField.classList.add('addressField');
            newAddressField.innerHTML = `
                <input type="text" name="addresses[${addressFieldIndex}][address]" placeholder="Address Line 1">
                <input type="text" name="addresses[${addressFieldIndex}][city]" placeholder="City">
                <input type="text" name="addresses[${addressFieldIndex}][state]" placeholder="State">
                <input type="text" name="addresses[${addressFieldIndex}][zip_code]" placeholder="Zip Code">
                <button type="button" class="deleteAddressField">Delete</button>
            `;
            addressFieldsContainer.appendChild(newAddressField);
            addressFieldIndex++;
            addDeleteAddressFieldListeners();
        });

        function addDeleteAddressFieldListeners() {
            const deleteAddressFieldBtns = document.querySelectorAll('.deleteAddressField');
            deleteAddressFieldBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const addressField = btn.parentNode;
                    addressFieldsContainer.removeChild(addressField);
                });
            });
        }

        addDeleteAddressFieldListeners();
    </script>
@endsection
