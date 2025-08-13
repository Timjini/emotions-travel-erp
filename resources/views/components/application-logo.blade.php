<img 
    src="{{ $company && $company->logo_path ? Storage::url($company->logo_path) : asset('/public/images/default-company-logo.png') }}"
    alt="{{ $company->name ?? 'Default Company' }} Logo"
    class="h-16 w-auto mx-auto md:mx-0"
/>
