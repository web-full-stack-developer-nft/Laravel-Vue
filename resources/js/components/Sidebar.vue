<template>
<!-- Side bar-->
<div id="sidebar" class="h-screen w-64 menu bg-white text-white px-4 flex nunito static fixed shadow">
    <ul class="list-reset w-full">
        <li class="text-center ">   <router-link to="/"><img src="/logo.png" alt="" class="object-contain h-24 w-24 m-auto"></router-link>     </li>
        <li class="my-2 md:my-0">
            <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400 flex items-center">
                <svg aria-hidden="true" data-prefix="fad" data-icon="house-damage" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-4 h-4">
                    <g class="fa-group">
                        <path fill="currentColor" d="M512 311.08V496a16 16 0 01-16 16H319.82l-39.92-55.26 104.11-64L236 256l60.11 119.2L192 439.18 229.24 512H80a16 16 0 01-16-16V311c1.78-1.21 3.85-1.89 5.47-3.35L288 115l218.74 192.9c1.55 1.36 3.57 2.02 5.26 3.18z" class="fa-secondary"/>
                        <path fill="currentColor" d="M236 256l60.11 119.2L192 439.18 229.24 512h90.58l-39.92-55.26 104.11-64zm334.7-19.74L512 184.43V48a16 16 0 00-16-16h-64a16 16 0 00-16 16v51.67L314.76 10.29a39.85 39.85 0 00-53.45 0l-256 226a16 16 0 00-1.21 22.59l21.41 23.79a16 16 0 0022.59 1.21L277.43 81.61a16 16 0 0121.17 0l229.32 202.27a16 16 0 0022.6-1.2l21.4-23.82a16 16 0 00-1.22-22.6z" class="w-1 h-1"/>
                    </g>
                </svg>
                <span class="w-full inline-block pb-1 md:pb-0 text-sm pl-2">Home</span>
            </a>
        </li>
        <li class="my-2 md:my-0 ">
            <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                <i class="fas fa-tasks fa-fw mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Tasks</span>
            </a>
        </li>
        <li class="my-2 md:my-0">
            <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                <i class="fa fa-envelope fa-fw mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Messages</span>
            </a>
        </li>
        <li class="my-2 md:my-0">
            <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                <i class="fas fa-chart-area fa-fw mr-3 text-indigo-400"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Analytics</span>
            </a>
        </li>
        <li class="my-2 md:my-0">
            <a href="#" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                <i class="fa fa-wallet fa-fw mr-3"></i><span class="w-full inline-block pb-1 md:pb-0 text-sm">Payments</span>
            </a>
        </li>
    </ul>

</div>
</template>

<style>
    
</style>