<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Doğrulama mesajları
    |--------------------------------------------------------------------------
    |
    | Aşağıdakı maddələr doğrulama sinif tərəfindən istifadə edilən standart səhvdir
    | mesajlarıdır. `sizə` kimi bəzi qaydaların çoxsaylı variantları
    | var. Hər birini ayrıca düzəldə bilərsiniz.
    |
    */

    'accepted' => ':attribute qəbul edilməlidir.',
    'active_url' => ':attribute etibarlı URL olmalıdır.',
    'after' => 'Girdiyiniz :attribute, :date tarixinden sonrakı bir tarix olmalıdır.',
    'after_or_equal' => ':attribute tarixi :date tarixindən sonra və ya o tarixə bərabər olmalıdır.',
    'alpha' => ':attribute yalnız hərflərdən ibarət olmalıdır.',
    'alpha_dash' => ':attribute yalnız hərflərdən, nömrələrdən və tirelərdən ibarət olmalıdır.',
    'alpha_num' => ':attribute yalnız hərf və rəqəmlərdən ibarət olmalıdır.',
    'array' => ':attribute array olmalıdır.',
    'before' => ':attribute bundan daha əvvəlki bir tarix olmalıdır :date.',
    'before_or_equal' => ':attribute tarixi :date tarixindən əvvəl ve ya tarixinə bərabər tarix olmalıdır.',
    'between' => [
        'numeric' => ':attribute :min - :max arasında olmalıdır.',
        'file' => ':attribute :min - :max arasındakı kilobayt dəyəri olmalıdır.',
        'string' => ':attribute :min - :max arasında sinvollardan ibarət olmalıdır.',
        'array' => ':attribute :min - :max arasında obyektə sahib olmalıdır.',
    ],
    'boolean' => ':attribute sadece doğru veya yanlış olmalıdır.',
    'confirmed' => ':attribute tekrarı uyğun gəlmir.',
    'date' => ':attribute keçerli tarix olmalıdır.',
    'date_equals' => ':attribute ilə :date eyni tarixlər olmalıdır.',
    'date_format' => ':attribute :format formatı ilə uyğun gəlmir.',
    'different' => ':attribute ilə :other birbirindən fərqli olmalıdır.',
    'digits' => ':attribute :digits rakam olmalıdır.',
    'digits_between' => ':attribute :min ilə :max arasında ədəd olmalıdır.',
    'dimensions' => ':attribute şəkil ölçüləri etibarsızdır.',
    'distinct' => ':attribute alanı təkrarlanan bir değere sahip.',
    'email' => ':attribute forması etibarsızdır.',
    'exists' => 'Seçili :attribute etibarsızdır.',
    'file' => ':attribute dosya olmalıdır.',
    'filled' => ':attribute alanının doldurulması məcburidir.',
    'ends_with' => ':attribute, bunlardan biriylə bitməlidir :values',
    'gt' => [
        'numeric' => ':attribute, :value dəyərindən büyük olmalı.',
        'file'    => ':attribute, :value KB ölçüsündən büyük olmalı.',
        'string'  => ':attribute, :value simvoldan uzun olmalı.',
        'array'   => ':attribute, :value dənədən çox olmalı.',
    ],
    'gte' => [
        'numeric' => ':attribute, :value qədər vəya daha böyük olmalı.',
        'file'    => ':attribute, :value KB ölçüsü qədər vəya daha büyük olmalı.',
        'string'  => ':attribute, :value simvol qədər vəya daha uzun olmalı.',
        'array'   => ':attribute, :value dənə vəya daha çox olmalı.',
    ],
    'image' => ':attribute alanı rəsim dosyası olmalıdır.',
    'in' => ':attribute dəyəri etibarsız.',
    'in_array' => ':attribute alanı :other içində mövcud deyil.',
    'integer' => ':attribute tam ədəd olmalıdır.',
    'ip' => ':attribute keçərli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute keçərli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute keçərli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute keçərli bir JSON dəyişləni olmalıdır.',
    'lt' => [
        'numeric' => ':attribute, :value dəyərindən balaca olmalı.',
        'file'    => ':attribute, :value KB ölçüsündən balaca olmalı.',
        'string'  => ':attribute, :value simvolundan qısa olmalı.',
        'array'   => ':attribute, :value dənədən az olmalı.',
    ],
    'lte' => [
        'numeric' => ':attribute, :value qədər veya daha balaca olmalı.',
        'file'    => ':attribute, :value KB ölçüsü qədər vəya daha balaca olmalı.',
        'string'  => ':attribute, :value simvol qədər vəya daha qısa olmalı.',
        'array'   => ':attribute, :value dənə vəya daha az olmalı.',
    ],
    'max' => [
        'numeric' => ':attribute dəyəri :max dəyərindən balaca olmalıdır.',
        'file' => ':attribute dəyəri :max kilobayt dəyərindən balaca olmalıdır.',
        'string' => ':attribute dəyəri :max karakter dəyərindən balaca olmalıdır.',
        'array' => ':attribute dəyəri :max ədədindən az obyektə sahib olmalıdır.',
    ],
    'mimes' => ':attribute dosya formatı :values olmalıdır.',
    'mimetypes' => ':attribute dosya formatı :values olmalıdır.',
    'min' => [
        'numeric' => ':attribute dəyəri :min dəyərindən büyük olmalıdır.',
        'file' => ':attribute dəyəri :min kilobayt dəyərindən büyük olmalıdır.',
        'string' => ':attribute dəyəri :min karakter dəyərindən büyük olmalıdır.',
        'array' => ':attribute ən az :min obyektə sahib olmalıdır.',
    ],
    'not_in' => 'Seçili :attribute etibarsız.',
    'not_regex' => ':attribute format etibarsız.',
    'numeric' => ':attribute ədəd olmalıdır.',
    'password' => 'Şifrə Etibarsız.',
    'present' => ':attribute alanı mövcud olmalıdır.',
    'regex' => ':attribute formatı etibarsızdır.',
    'required' => ':attribute alanı gərəklidir.',
    'required_if' => ':attribute alanı, :other :value dəyərinə sahib olduğunda məcburidir.',
    'required_unless' => ':attribute alanı, :other alanı :value dəyərlərindən birinə sahib olmadığında məcburidir.',
    'required_with' => ':attribute alanı :values varken məcburidir.',
    'required_with_all' => ':attribute alanı hərhansı bir :values dəyəri varləm məcburidir.',
    'required_without' => ':attribute alanı :values yoxkən məcburidir.',
    'required_without_all' => ':attribute alanı :values dəyərlərinin hərhansı biri yoxkən məcburidir.',
    'same' => ':attribute ilə :other eşləşməlidir.',
    'size' => [
        'numeric' => ':attribute :size olmalıdır.',
        'file' => ':attribute :size kilobyt olmalıdır.',
        'string' => ':attribute :size simvol olmalıdır.',
        'array' => ':attribute :size obyektə sahib olmalıdır.',
    ],
    'starts_with' => ':attribute bunlardan biri ilə başlamalıdır: :values',
    'string' => ':attribute string olmalıdır.',
    'timezone' => ':attribute etibarlı saat dilimi olmalıdır.',
    'unique' => ':attribute daha evvəl qeydiyyat edilmiş.',
    'uploaded' => ':attribute yükləmesi uğursuz.',
    'url' => ':attribute formatı etibarsız.',
    'uuid' => ':attribute UUID formatına uygun olmalıdır.',

    /*
    |--------------------------------------------------------------------------
    | Özəlləştirilmiş doğrulama mesajları
    |--------------------------------------------------------------------------
    |
    | Bu alanda hər atribut  (attribute) ve qayda (rule) ikilisinə özəl xəta
    | mesajları müəyyən edə bilərsiz. Bu özəllik, isdifadəçiyə daha həqiqi
    | mətinler göstərməniz üçün olduqca faydalıdır.
    |
    | Örnək olarak:
    |
    | 'email.email': 'Daxil etdiyiniz e-poçt ünvanı etibarlı deyil.'
    | 'x.regex': 'x alanı için "a-b.c" formatında veri girməlisiniz.'
    |
    */

    'custom' => [
        'x' => [
            'regex' => 'x alanı için "a-b.c" formatında veri girmelisiniz.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Özelleştirilmiş isimleri
    |--------------------------------------------------------------------------
    |
    | Bu alandaki bilgilər "email" kimi isimlerini "e-posta adresi"
    | kimi daha oxuna bilir mətinərə çevirmək üçün istifadə edilir. Bu bilgilər
    | xəta mesajlarının daha təmiz olmasını təmin edir.
    |
    | Örnək olarak:
    |
    | 'email' => 'e-posta adresi',
    | 'password' => 'şifrə',
    |
    */

    'attributes' => [],

];
