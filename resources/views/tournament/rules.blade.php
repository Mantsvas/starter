@extends('layouts.app')

@section('content')
<div class="container text-justify pr-5">

    <h2 class="text-center">Turnyro Taisyklės</h2>

    <h4 class="text-center">Registracija</h4>
    <ul class="">
        <p>
            Registracija trunka savaitę laiko.
            Norint užsiregistruoti, apie tai reikia pranešti klano chate.
            Dalyvauti gali visi klane esantys nariai.
        </p>
    </ul>
    <h4 class="text-center">Turnyro struktūra</h4>
    <ul class="">
        <p>
            Užsiregistravę dalyviai burtų keliu suskirstomi poromis.
            Poros laimėtojas keliauja į kitą etapą.
            Vienam etapui skiriama viena savaitė. Per šią savaitę abu poros dalyviai turi susitarti, kada bus žaidžiama. Poros nugalėtojas keliauja į kitą etapą, pralaimėtojas iškrenta iš turnyro.
            Pasibaigus pirmajam etapui prasideda antras etapas, kuris vel trunka savaitę laiko tokiu pat principu kaip ir pirmas. Ir taip kol turėsim Turnyro nugalėtoją
            Jeigu etapo metu dėl kažkokių priežasčių žaidėjas išeina (ar yra išmetamas) iš klano, tada jo varžovas automatiškai išeina į kitą etapą. Net jeigu išmestas dalyvis buvo laimėjęs.
        </p>
    </ul>
    <h4 class="text-center">Iki 3 pergalių</h4>
    <ul class="">
        <p>
            Poros nugalėtojas paaiškėja, kai vienas iš žaidėjų laimi 3 kartus.
            Maksimalus dvikovų skaičius vienos poros nugalėtojui išsiaiškinti 5 dvikovos.
            Lygiųjų atveju pralaimi tas, kurio bokštelis turi mažiau gyvybės.
        </p>
    </ul>

</div>
@endsection
