@extends('layouts.customer')

@section('customer_content')
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    


                        <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ !$errors->has('password') ? 'active' : '' }} fw-bold" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">Personal Information</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $errors->has('password') ? 'active' : '' }} fw-bold" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">Security & Password</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="profileTabsContent">
                            
                            <!-- Personal Info Tab -->
                            <div class="tab-pane fade {{ !$errors->has('password') ? 'show active' : '' }}" id="info" role="tabpanel">
                                <form action="{{ route('customer.profile.update.info') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Full Name</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Phone Number</label>
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="+880 1711 000000">
                                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Email Address</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Address</label>
                                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}" placeholder="123 Street Name">
                                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold"><i class="bi bi-save me-2"></i> Save Information</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Password Tab -->
                            <div class="tab-pane fade {{ $errors->has('password') ? 'show active' : '' }}" id="password" role="tabpanel">
                                <form action="{{ route('customer.profile.update.password') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <p class="text-muted small mb-4">Enter your new password below to change it.</p>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">New Password</label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password" required>
                                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Confirm New Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter new password" required>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold"><i class="bi bi-shield-lock me-2"></i> Update Password</button>
                                    </div>
                                </form>
                            </div>

                        </div>

                </div>
            </div>
@endsection
