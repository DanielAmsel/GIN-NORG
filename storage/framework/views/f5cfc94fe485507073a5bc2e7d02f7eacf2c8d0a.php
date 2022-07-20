<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="<?php echo e(URL('assets/images/logo32col.png')); ?>" type="image/png" sizes="32x32">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Norg</title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer>
        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()
        })
    </script>


    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">


</head>

<body>

    <div class="container center_div">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    <img src="<?php echo e(URL('assets/images/logo32col.png')); ?>" alt="LogoNORG" width="auto" height="auto">
                    Norg
                </a>

                <?php if(auth()->guard()->guest()): ?>

                <?php elseif(Auth::user()->role == 'Default'): ?>

                        <div class="collapse navbar-collapse " id="navbarSupportedContent">
                            <!-- Right Side Of Navbar -->

                            <ul class="navbar-nav ms-auto">
                                <!-- Authentication Links -->

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <?php echo e(Auth::user()->name); ?>

                                    </a>


                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            <?php echo e(__('Logout')); ?>

                                        </a>

                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                            class="d-none">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </div>

                                </li>

                            </ul>
                        </div>
                        <main class="py-4">
                            <?php echo $__env->yieldContent('onDefault'); ?>
                        </main>
                <?php else: ?>
                    <?php if(Auth::user()->role == 'Arzt' || Auth::user()->role == 'Sekretariat'): ?>
                        <a class="navbar-brand" href="<?php echo e(url('/sentSamples')); ?>">
                            Verschickte Proben
                        </a>
                    <?php else: ?>
                        <a class="navbar-brand" href="<?php echo e(url('/sampleList')); ?>">
                            Proben im Tank
                        </a>
                        <a class="navbar-brand" href="<?php echo e(url('/sentSamples')); ?>">
                            Verschickte Proben
                        </a>
                        <a class="navbar-brand" href="<?php echo e(url('/removedSamples')); ?>">
                            Entfernte Proben
                        </a>
                        <a class="navbar-brand" href="<?php echo e(url('/manageTanks')); ?>">
                            Tanks verwalten
                        </a>
                        <?php if(Auth::user()->role == 'Administrator'): ?>
                            <a class="navbar-brand" href="<?php echo e(url('/manageUser')); ?>">
                                User verwalten
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>


                        <div class="collapse navbar-collapse " id="navbarSupportedContent">
                            <!-- Right Side Of Navbar -->

                            <ul class="navbar-nav ms-auto">
                                <!-- Authentication Links -->

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <?php echo e(Auth::user()->name); ?>

                                    </a>


                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                            <?php echo e(__('Logout')); ?>

                                        </a>

                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                            class="d-none">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </div>

                                </li>

                        </ul>
                    </div>
            </div>

        </nav>

        <?php if(Auth::user()->email == "Platzhalter@Überschreiben.de"): ?>
            <div class="alert alert-danger center_div" role="alert">
                <b>Dieser Nutzer ist zum Einrichten der Applikation! <br>
                    Geben Sie einem anderen Nutzer die Rolle "Administrator" und entfernen danach diesen Nutzer (Name: "AdminNutzer", E-Mail: "Platzhalter@Überschreiben.de")!
                </b>
            </div>
        <?php endif; ?>
        
        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        <?php endif; ?>

            </div>
        </div>

        </nav>
        <main class="py-4">
            <?php echo $__env->yieldContent('login'); ?>
        </main>

    </div>


</body>
<footer class="text-center fixed-bottom">
    <div class="fixed-bottom text-center align-items-center" style="background-color: lightgray">
        <span class="me-5 text-muted">Information zum <a href="/imprint">Impressum</a> und <a
                href="/privacy">Datenschutz</a> erhalten Sie über die angegebenen Links.</span>
    </div>
</footer>

</html>
<?php /**PATH C:\Users\Sebastian\Documents\GitHub\norg\resources\views/layouts/app.blade.php ENDPATH**/ ?>