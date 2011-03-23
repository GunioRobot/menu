<?php

/*
 * A project from Axcoto.Com
 * by kureikain
 */
return array(
    'primary' => array(
        array(
            'text' => 'Dashboard',
            'uri' => 'admin/welcome',
            'sub' => array(
            )
        ),
        array(
            'text' => 'Statistic',
            'uri' => 'admin/statistic'
        ),
        array(
            'text' => 'Category&amp; item',
            'uri' => 'admin/category',
            'sub' => array(
                array(
                    'text' => 'Listing',
                    'uri' => 'admin/category/index'
                ),
                array(
                    'text' => 'New Category',
                    'uri' => 'admin/category/new'
                )
            )
        ),
        array(
            'text' => 'Campaign',
            'uri' => 'admin/campaign',
            'sub' => array(
                array(
                    'text' => 'Listing',
                    'uri' => 'admin/campaign/index'
                ),
                array(
                    'text' => 'New Campaign',
                    'uri' => 'admin/campaign/new'
                )
            )
        ),
        array(
            'text' => 'Setting',
            'uri' => 'admin/setting',
        ),
    ),
    'footer' => array(
    ),


    'frontpage-primary' => array(
        array(
            'text' => 'Home',
            'uri' => 'welcome',
            'onclick' => 'return app.loadPage(\'quizz/index\')'
        ),
        array(
            'text' => 'Events',
            'uri' => 'events'
        ),
        array(
            'text' => 'My vote',
            'uri' => 'events',
            'onclick' => 'return app.loadPage(\'quizz/result\')',
        ),
        array(
            'text' => 'Invite Friends',
            'uri' => 'events',
        ),
    ),

    
);
