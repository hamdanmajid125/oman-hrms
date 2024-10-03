<?php
function profileimage(){
    return Auth::user()->image ? asset(Auth::user()->image) : asset('images/no-user.png');
}
