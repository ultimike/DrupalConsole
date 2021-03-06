<?php

/**
 * @file
 * Contains Drupal\Console\Command\ModuleTrait.
 */

namespace Drupal\Console\Command;

use Drupal\Console\Style\DrupalStyle;

/**
 * Class MenuTrait
 * @package Drupal\Console\Command
 */
trait MenuTrait
{
    /**
   * @param \Drupal\Console\Style\DrupalStyle $io
   * @param $className
   *  The form class name
   * @return string
   * @throws \Exception
   */
    public function menuQuestion(DrupalStyle $io, $className)
    {
        if ($io->confirm(
            $this->trans('commands.generate.form.questions.menu_link_gen'),
            true
        )) {
            // now we need to ask them where to gen the form
            // get the route
            $menu_options = [
                'menu_link_gen' => true,
            ];
            $menu_link_title = $io->ask(
                $menu_link_title = $this->trans('commands.generate.form.questions.menu_link_title'),
                $className
            );
            $menuLinkFile = sprintf(
                '%s/core/modules/system/system.links.menu.yml',
                $this->getSite()->getSiteRoot()
            );

            $config = $this->getApplication()->getConfig();
            $menuLinkContent = $config->getFileContents($menuLinkFile);

            $menu_parent = $io->choiceNoList(
                $menu_parent = $this->trans('commands.generate.form.questions.menu_parent'),
                array_keys($menuLinkContent),
                'system.admin_config_system'
            );

            $menu_link_desc = $io->ask(
                $menu_link_desc = $this->trans('commands.generate.form.questions.menu_link_desc'),
                'A description for the menu entry'
            );
            $menu_options['menu_link_title'] = $menu_link_title;
            $menu_options['menu_parent'] = $menu_parent;
            $menu_options['menu_link_desc'] = $menu_link_desc;
            return $menu_options;
        }
    }
}
