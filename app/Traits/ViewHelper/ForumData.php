<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.02.19
 * Time: 12:17
 */

namespace App\Traits\ViewHelper;

use App\{
    ForumSection, ForumTopic, SectionIcon, Services\Forum\SectionService, Services\Forum\TopicService
};
use Carbon\Carbon;

trait ForumData
{
    /**
     * @return mixed
     */
    public function getLastForum()
    {
        if (!self::$instance->last_forum) {
            if (!self::$instance->all_sections) {
                self::$instance->getAllForumSections();
            }
            self::$instance->last_forum = self::$instance->all_sections->where('is_general', 1);
        }
        return self::$instance->last_forum;
    }

    /**
     * @return ForumSection[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllForumSections()
    {
        if (!self::$instance->all_sections) {
            self::$instance->all_sections = SectionService::getAllSections();
        }
        return self::$instance->all_sections;
    }

    /**
     * @return mixed
     */
    public function getGeneralSectionsForum()
    {
        if (!self::$instance->general_sections) {
            self::$instance->general_sections = SectionService::getGeneralSectionsForum();
        }
        return self::$instance->general_sections;
    }

    /**
     * Get icon url from Id
     *
     * @return mixed
     */
    public function getSectionIcons()
    {
        if (!self::$instance->section_icons){
            $icons = SectionIcon::all();
            foreach ($icons as $icon) {
                self::$instance->section_icons[$icon->id] = $icon->icon;
            }
            return self::$instance->section_icons;
        }
        return self::$instance->section_icons;
    }

    /**
     * Get last news for footer
     *
     * @return mixed
     */
    public function getLastNewsFooter()
    {
        if (!self::$instance->last_news_footer){
            self::$instance->last_news_footer = TopicService::getLastNews(10);
        }
        return self::$instance->last_news_footer;
    }
}