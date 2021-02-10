@extends('layouts.app')
@section('content')
<div class="container-fluid py-lg-5 py-3">
    <div class="container" style="min-height: 60vh;">
        <div class="row">
            <div class="col-lg-6 col-12 d-flex align-items-center">
                <div>
                <h1 class="font-weight-light mb-4" style="font-size: 50px;">
                    <span class="font-weight-bold">Building</span>City
                </h1>
                    <div class="col-12 px-0">
                <p class="font-weight-normal font-size-16 line-height-140">
                    Строительная компания Билдинг Сити. <br>Строительство эко-домов в Бишкеке!
                </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <img class="img-fluid" src="{{ asset('img/pic1.png') }}" alt="">
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4 mt-4" style="background-color: #f8f9fa">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 order-lg-first order-last px-lg-5 px-0">
                <img class="img-fluid" src="{{ asset('img/pic2.png') }}" alt="">
            </div>
            <div class="col-lg-6 col-12 d-flex align-items-center px-lg-5 px-2">
                <div>
                    <h2 class="font-weight-medium mb-3" style="font-size: 36px;">О нас</h2>
                <p class="font-weight-normal font-size-16 line-height-140 mb-3">
                    Строительная компания Билдинг Сити основана совсем недавно.
                </p>
                <p class="font-weight-normal font-size-16 line-height-140">
                    Компания занимается строительством быстровозводимых, экологически чистых, безопасных, теплых домов по современной канадской технологии из Сип панелей.
                </p>
                        <p class="font-weight-normal font-size-16 line-height-140">
                            Компания Билдинг Сити создавалась для строительства эко городков на территории КР.
                        </p>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="container-fluid py-4 mt-4">
        <div class="container">
            <h2 class="font-weight-medium text-center mb-3" style="font-size: 36px;">Технология строительства</h2>

        <div class="row mt-5">
            <div class="col-lg-6 col-12 d-flex align-items-center">
                <div>
                <p class="font-weight-normal font-size-16 line-height-140">
                    Строительство идет из самых качественных материалов производства  России, панели ОСП 3 это панели, которые соответствуют ГОСТ для постройки жилых домов.
                </p>
                <p class="font-weight-normal font-size-16 line-height-140">
                    Пенопласт, как утеплитель, сам по себе нейтрален, обрезная доска и брус из российской сосны, все материалы проходят антисептическую и противопожарную обработку.
                </p>
                    <p class="font-weight-normal font-size-16 line-height-140">
                        Сип панели состоят из 2 ОСП листов между которыми находится пенопласт толщиной 15 см. СИП панель - это обычно панель размером 2,8м на 1,25м и такую панель может поднять и передвигать один человек. Поэтому монтаж дома происходит в кратчайшие сроки.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-12 text-center">
                <img class="w-50 img-fluid" src="{{ asset('img/osp1.jpg') }}" alt="">
                <img class="w-50 img-fluid" src="{{ asset('img/osp2.png') }}" alt="">
            </div>
        </div>
        </div>
    </div>
<div class="container-fluid py-5" style="background-color: #f8f9fa">
    <div class="container">
            <h2 class="font-weight-medium text-center mt-5" style="font-size: 36px;">Преимущества</h2>
        <div class="row mt-5 pt-5">
            <div class="col-lg-6 col-12 row align-items-center justify-content-center">
                <div class="col-6 text-center">
                    <img style="width:100px;" class="img-fluid" src="{{ asset('img/salary.svg') }}" alt="">
                    <p class="font-weight-medium font-size-18 line-height-140 mt-3">
                        Доступно!
                    </p>
                </div>
                <div class="col-6 text-center">
                    <img style="width:100px;" class="img-fluid" src="{{ asset('img/eco.svg') }}" alt="">
                    <p class="font-weight-medium font-size-18 line-height-140 mt-3">
                        Экологично!
                    </p>
                </div>
                <div class="col-6 text-center">
                    <img style="width:100px;" class="img-fluid" src="{{ asset('img/fast-time.svg') }}" alt="">
                    <p class="font-weight-medium font-size-18 line-height-140 mt-3">
                        Быстро!
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-12 order-lg-last order-first">
                <p class="font-weight-normal font-size-16 line-height-140">
                    Бригада из 4 человек может построить дом 65кв метров, при условии готового фундамента, в течении 7 рабочих дней.  Далее нужна отделка дома. Компания предлагает на выбор несколько проектов домов от <span class="font-weight-bold">65 кв. м в 1 этаж</span> , до <span class="font-weight-bold">135 кв. м в два этажа</span>, а также строительство домов по проектам клиентов.
                </p>
                <p class="">Преимущество домов из сип панелей трудно переоценить, дома ко всему вышеперечисленному обладают несомненным преимуществом в сроках строительства и самое главное это не большая цена. К примеру дом на своем участке площадью в 65 кв метров обойдется застройщику примерно в <span class="font-weight-bold">10 – 13 тыс долл.</span></p>
            </div>
        </div>
        </div>
    </div>
@endsection