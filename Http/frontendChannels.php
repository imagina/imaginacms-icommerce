<?php

//TODO:disable broadcasting
Broadcast::channel('global', function () {
  return true;
});

