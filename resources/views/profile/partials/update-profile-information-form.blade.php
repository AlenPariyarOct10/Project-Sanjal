<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Profile Image -->
            <div class="w-full md:w-1/3">
                <x-input-label for="profile_image" :value="__('Profile Image')" />
                <div class="mt-2 flex flex-col items-center">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover mb-4 border-2 border-gray-200">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center mb-4 border-2 border-gray-200">
                            <span class="text-gray-400 text-4xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <input id="profile_image" name="profile_image" type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
            </div>

            <!-- Basic Info -->
            <div class="flex-1 space-y-6">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800">
                                {{ __('Your email address is unverified.') }}
                                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>
                        </div>
                    @endif
                </div>

                <div>
                    <x-input-label for="college_id" :value="__('Institution / College')" />
                    <select id="college_id" name="college_id" class="mt-1 block w-full border-gray-300 focus:border-black focus:ring-black rounded-md shadow-sm">
                        <option value="">-- Select College --</option>
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}" {{ old('college_id', $user->college_id) == $college->id ? 'selected' : '' }}>{{ $college->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('college_id')" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Bio / Description')" />
                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-black focus:ring-black rounded-md shadow-sm" rows="3">{{ old('description', $user->description) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Contact Info -->
            <div class="space-y-6">
                <h3 class="font-bold text-gray-900 border-b pb-2">Contact Information</h3>
                
                <div>
                    <x-input-label for="phone" :value="__('Phone Number')" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <div>
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="city" :value="__('City')" />
                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" />
                    </div>
                    <div>
                        <x-input-label for="state" :value="__('State')" />
                        <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $user->state)" />
                    </div>
                    <div>
                        <x-input-label for="country" :value="__('Country')" />
                        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->country)" />
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="space-y-6">
                <h3 class="font-bold text-gray-900 border-b pb-2">Social & Online Presence</h3>
                
                <div>
                    <x-input-label for="website" :value="__('Personal Website')" />
                    <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website', $user->website)" placeholder="https://..." />
                </div>

                <div>
                    <x-input-label for="github" :value="__('GitHub Profile')" />
                    <x-text-input id="github" name="github" type="url" class="mt-1 block w-full" :value="old('github', $user->github)" placeholder="https://github.com/..." />
                </div>

                <div>
                    <x-input-label for="linkedin" :value="__('LinkedIn Profile')" />
                    <x-text-input id="linkedin" name="linkedin" type="url" class="mt-1 block w-full" :value="old('linkedin', $user->linkedin)" placeholder="https://linkedin.com/in/..." />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="facebook" :value="__('Facebook')" />
                        <x-text-input id="facebook" name="facebook" type="url" class="mt-1 block w-full" :value="old('facebook', $user->facebook)" placeholder="https://facebook.com/..." />
                    </div>
                    <div>
                        <x-input-label for="twitter" :value="__('Twitter')" />
                        <x-text-input id="twitter" name="twitter" type="url" class="mt-1 block w-full" :value="old('twitter', $user->twitter)" placeholder="https://twitter.com/..." />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="instagram" :value="__('Instagram')" />
                        <x-text-input id="instagram" name="instagram" type="url" class="mt-1 block w-full" :value="old('instagram', $user->instagram)" placeholder="https://instagram.com/..." />
                    </div>
                    <div>
                        <x-input-label for="youtube" :value="__('YouTube')" />
                        <x-text-input id="youtube" name="youtube" type="url" class="mt-1 block w-full" :value="old('youtube', $user->youtube)" placeholder="https://youtube.com/..." />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6 border-t">
            <x-primary-button class="bg-black hover:bg-gray-800">{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold"
                >{{ __('Profile updated successfully.') }}</p>
            @endif
        </div>
    </form>
</section>
