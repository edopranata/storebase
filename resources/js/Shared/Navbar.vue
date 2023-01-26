<template>
    <div class="navbar sticky top-0 z-50 bg-base-200/80 h-20 flex justify-between md:justify-end border-b-2 border-primary print:hidden">
        <div class="flex-1 lg:hidden">
            <label for="my-drawer-2" class="btn btn-square btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </label>
        </div>

        <div class="flex-none">
            <button class="hidden btn btn-ghost btn-circle" @click="requestFullScreen()">
                F
            </button>
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <span class="w-11 rounded-full">
                        <img alt="SBR Logo" src="/img/sbr-logo-no-padding.png" />
                    </span>
                </label>
                <ul tabindex="0" class="menu menu-compact dropdown-content mt-[15px] p-2 shadow bg-base-100 rounded-b-xl w-52 border-t-2 border-primary">
                    <li><a class="justify-between">{{ $page.props.auth.user.name}}</a></li>
                    <li><Link :href="route('logout')" as="button" method="post">Logout</Link></li>
                </ul>
            </div>
        </div>
    </div>
    <notifications position="top right" class="mt-2" />
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";

let requestFullScreen =  () => {
    // Supports most browsers and their versions.
    let element = document.body
    var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;

    if (requestMethod) { // Native full screen.
        requestMethod.call(element);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
}
</script>

