@if(!empty($currencies) && count($currencies))
    @php
        $userCurrency = currency();
        $generalSettings = getGeneralSettings(); // Fetch the general settings
        $isMultiCurrencyEnabled = !empty($generalSettings['user_multi_currency']) && $generalSettings['user_multi_currency'];
    @endphp

    <div class="js-currency-select custom-dropdown position-relative">
        <form id="currency-form" action="/set-currency" method="post" style="display: none;">
            {{ csrf_field() }}
            <input type="hidden" name="currency" id="currency-input" value="{{ $userCurrency }}" disabled>
            @if(!empty($previousUrl))
                <input type="hidden" name="previous_url" value="{{ $previousUrl }}" disabled>
            @endif
        </form>

        <!-- Check if multi-currency is enabled -->
        @if($isMultiCurrencyEnabled)
            <!-- Display the custom-dropdown toggle (currency label) if multi-currency is enabled -->
            <div class="custom-dropdown-toggle d-flex align-items-center cursor-pointer">
                <div class="mr-5 text-secondary">
                    <span class="js-lang-title font-14">{{ $userCurrency }} ({{ currencySign($userCurrency) }})</span>
                </div>
                <i data-feather="chevron-down" class="icons" width="14px" height="14px"></i>
            </div>

            <!-- Display the dropdown body with currency options -->
            <div class="custom-dropdown-body py-10">
                @foreach($currencies as $currencyItem)
                    <div class="js-currency-dropdown-item custom-dropdown-body__item cursor-pointer {{ ($userCurrency == $currencyItem->currency) ? 'active' : '' }}" data-value="{{ $currencyItem->currency }}" data-title="{{ $currencyItem->currency }} ({{ currencySign($currencyItem->currency) }})">
                        <div class="d-flex align-items-center w-100 px-15 py-5 text-gray bg-transparent">
                            <div class="size-32 position-relative d-flex-center bg-gray100 rounded-sm">
                                {{ currencySign($currencyItem->currency) }}
                            </div>
                            <span class="ml-5 font-14">{{ currenciesLists($currencyItem->currency) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- If multi-currency is disabled, show the current currency label only -->
            <div class="custom-dropdown-toggle d-flex align-items-center cursor-not-allowed">
                <div class="mr-5 text-secondary">
                    <span class="js-lang-title font-14">{{ $userCurrency }} ({{ currencySign($userCurrency) }})</span>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Handle currency selection click
        document.querySelectorAll('.js-currency-dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                const selectedCurrency = this.dataset.value; // Get selected currency

                // Update the hidden input with the selected currency
                document.getElementById('currency-input').value = selectedCurrency;

                // Show loading spinner while changing the currency
                Swal.fire({
                    title: 'Changing Currency...',
                    text: 'Please wait while we change your currency.',
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading(); // Show loading spinner
                    }
                });

                // Send request to update the selected currency
                fetch('/set-currency', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ currency: selectedCurrency })
                })
                .then(response => response.json()) // Parse the JSON response
                .then(data => {
                    Swal.close();  // Close the loading spinner

                    if (data.success) {
                        // If currency change is successful
                        Swal.fire({
                            icon: 'success',
                            title: 'Currency Changed Successfully!',
                            text: `New currency: ${selectedCurrency}`,
                            timer: 3000,  // Alert closes after 3 seconds
                            timerProgressBar: true, // Show progress bar for timer
                            showConfirmButton: false, // Hide confirm button
                            didDestroy: () => {
                                location.reload();  // Reload page after alert closes
                            }
                        });
                    } else {
                        // If currency change fails
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to Change Currency',
                            text: data.message || 'There was an issue changing the currency.',
                        });
                    }
                })
                .catch(error => {
                    Swal.close();  // Close the loading spinner
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'An error occurred while changing the currency.',
                    });
                });
            });
        });
    </script>

@endif
