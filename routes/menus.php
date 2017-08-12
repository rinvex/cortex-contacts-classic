<?php

Menu::backendSidebar('resources')->routeIfCan('list-contacts', 'backend.contacts.index', '<i class="fa fa-briefcase"></i> <span>'.trans('cortex/contacts::common.contacts').'</span>');
