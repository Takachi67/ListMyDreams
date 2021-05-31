@extends('layouts.app')

@section('content')

    <div class="w-full">
        <div class="w-full h-52 md:h-96 bg-title flex flex-col justify-center items-center">
            <h1 class="text-3xl md:text-5xl text-title">Mentions légales</h1>
        </div>
        <div class="ml-10 mr-10 md:ml-20 md:mr-20 mt-10">
            <h2 class="font-bold text-5xl mb-5">Hébergement</h2>
            <p class="text-xl">Wishu utilise l'hébergeur * :</p>
            <h2 class="font-bold text-5xl mt-5 mb-5">Cookies</h2>
            <p class="text-xl">Wishu utilise des cookies uniquement dans le but de vous garder connecté sur le site durant votre utilisation.</p>
            <h2 class="font-bold text-5xl mt-5 mb-5">Données personnelles</h2>
            <p class="text-xl">Vos données personnelles ont été volontairement restreintes et ne sont utilisées que pour vous authentifier et vous identifier auprès de vos amis. Wishu ne partage pas vos données personnelles et s'engage à supprimer définitivement votre compte en nous envoyant un mail via notre <a href="mailto:wishu.contact@gmail.com">adresse mail de contact</a>.</p>
        </div>
    </div>

@endsection
