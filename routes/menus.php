<?php

declare(strict_types=1);

Menu::adminareaSidebar('resources')->routeIfCan('list-contacts', 'adminarea.contacts.index', '<i class="fa fa-briefcase"></i> <span>'.trans('cortex/contacts::common.contacts').'</span>');
Menu::tenantareaSidebar('resources')->routeIfCan('list-contacts', 'tenantarea.contacts.index', '<i class="fa fa-briefcase"></i> <span>'.trans('cortex/contacts::common.contacts').'</span>');
