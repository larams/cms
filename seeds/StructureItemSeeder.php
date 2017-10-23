<?php


use Illuminate\Database\Seeder;

class StructureItemSeeder extends Seeder
{

    public function run()
    {
        DB::table('structure_items')->delete();
        DB::table('translations_keywords')->delete();
        DB::table('translations_values')->delete();

        $siteId = DB::table('structure_items')->insertGetId(array('parent_id' => DB::raw('NULL'), 'name' => 'Site Name', 'level' => 1, 'type_id' => 1, 'left' => 1, 'right' => 14, 'tree' => 1, 'active' => 1));
        DB::table('structure_items')->insert(array('parent_id' => DB::raw('NULL'), 'name' => 'Galerija', 'level' => 1, 'type_id' => 17, 'left' => 15, 'right' => 16, 'tree' => 1, 'active' => 1));

        $firstLanguageId = DB::table('structure_items')->insertGetId(array('parent_id' => $siteId, 'name' => 'EN', 'uri' => 'en', 'level' => 2, 'type_id' => 2, 'left' => 2, 'right' => 7, 'tree' => 1, 'active' => 1));
        DB::table('structure_items')->insert(array('parent_id' => $firstLanguageId, 'name' => 'Pagrindinis meniu', 'level' => 3, 'type_id' => 11, 'left' => 3, 'right' => 4, 'tree' => 1, 'active' => 1));
        DB::table('structure_items')->insert(array('parent_id' => $firstLanguageId, 'name' => 'Papildomas meniu', 'level' => 3, 'type_id' => 11, 'left' => 5, 'right' => 6, 'tree' => 1, 'active' => 1));
        DB::table('structure_data')->insert(array('item_id' => $firstLanguageId, 'name' => 'meta_title', 'data' => ''));
        DB::table('structure_data')->insert(array('item_id' => $firstLanguageId, 'name' => 'meta_description', 'data' => ''));
        DB::table('structure_data')->insert(array('item_id' => $firstLanguageId, 'name' => 'short_code', 'data' => 'en'));

        $secondLanguageId = DB::table('structure_items')->insertGetId(array('parent_id' => $siteId, 'name' => 'LT', 'uri' => 'lt', 'level' => 2, 'type_id' => 2, 'left' => 8, 'right' => 13, 'tree' => 1, 'active' => 1));
        DB::table('structure_items')->insert(array('parent_id' => $secondLanguageId, 'name' => 'Pagrindinis meniu', 'level' => 3, 'type_id' => 11, 'left' => 9, 'right' => 10, 'tree' => 1, 'active' => 1));
        DB::table('structure_items')->insert(array('parent_id' => $secondLanguageId, 'name' => 'Papildomas meniu', 'level' => 3, 'type_id' => 11, 'left' => 11, 'right' => 12, 'tree' => 1, 'active' => 1));
        DB::table('structure_data')->insert(array('item_id' => $secondLanguageId, 'name' => 'meta_title', 'data' => ''));
        DB::table('structure_data')->insert(array('item_id' => $secondLanguageId, 'name' => 'meta_description', 'data' => ''));
        DB::table('structure_data')->insert(array('item_id' => $secondLanguageId, 'name' => 'short_code', 'data' => 'lt'));

        DB::table('translations_keywords')->insert(array('id' => 6, 'keyword' => 'admin.title.cms'));
        DB::table('translations_keywords')->insert(array('id' => 7, 'keyword' => 'admin.menu.content'));
        DB::table('translations_keywords')->insert(array('id' => 8, 'keyword' => 'admin.menu.gallery'));
        DB::table('translations_keywords')->insert(array('id' => 9, 'keyword' => 'admin.menu.translations'));
        DB::table('translations_keywords')->insert(array('id' => 10, 'keyword' => 'admin.menu.administrators'));
        DB::table('translations_keywords')->insert(array('id' => 11, 'keyword' => 'admin.menu.content_types'));
        DB::table('translations_keywords')->insert(array('id' => 12, 'keyword' => 'admin.title.translations'));
        DB::table('translations_keywords')->insert(array('id' => 31, 'keyword' => 'admin.text.keyword'));
        DB::table('translations_keywords')->insert(array('id' => 14, 'keyword' => 'admin.button.create'));
        DB::table('translations_keywords')->insert(array('id' => 15, 'keyword' => 'admin.button.save'));
        DB::table('translations_keywords')->insert(array('id' => 16, 'keyword' => 'admin.button.cancel'));
        DB::table('translations_keywords')->insert(array('id' => 17, 'keyword' => 'admin.button.edit'));
        DB::table('translations_keywords')->insert(array('id' => 18, 'keyword' => 'admin.button.delete'));
        DB::table('translations_keywords')->insert(array('id' => 19, 'keyword' => 'admin.table_heading.keyword'));
        DB::table('translations_keywords')->insert(array('id' => 20, 'keyword' => 'admin.table_heading.title'));
        DB::table('translations_keywords')->insert(array('id' => 21, 'keyword' => 'admin.table_heading.status'));
        DB::table('translations_keywords')->insert(array('id' => 22, 'keyword' => 'admin.text.logged_as'));
        DB::table('translations_keywords')->insert(array('id' => 23, 'keyword' => 'admin.menu.logout'));
        DB::table('translations_keywords')->insert(array('id' => 24, 'keyword' => 'admin.button.hidden'));
        DB::table('translations_keywords')->insert(array('id' => 26, 'keyword' => 'admin.field.title'));
        DB::table('translations_keywords')->insert(array('id' => 27, 'keyword' => 'admin.field.type'));
        DB::table('translations_keywords')->insert(array('id' => 28, 'keyword' => 'admin.button.add_new_tree_item'));
        DB::table('translations_keywords')->insert(array('id' => 29, 'keyword' => 'admin.button.add_new_item'));
        DB::table('translations_keywords')->insert(array('id' => 30, 'keyword' => 'admin.button.visible'));
        DB::table('translations_keywords')->insert(array('id' => 33, 'keyword' => 'admin.title.administrator.list'));
        DB::table('translations_keywords')->insert(array('id' => 34, 'keyword' => 'admin.table_heading.email'));
        DB::table('translations_keywords')->insert(array('id' => 35, 'keyword' => 'admin.table_heading.name'));
        DB::table('translations_keywords')->insert(array('id' => 36, 'keyword' => 'admin.table_heading.type'));
        DB::table('translations_keywords')->insert(array('id' => 37, 'keyword' => 'admin.role.developer'));
        DB::table('translations_keywords')->insert(array('id' => 38, 'keyword' => 'admin.table_heading.last_logged_at'));
        DB::table('translations_keywords')->insert(array('id' => 39, 'keyword' => 'admin.table_heading.last_logged_ip'));
        DB::table('translations_keywords')->insert(array('id' => 40, 'keyword' => 'admin.field.name'));
        DB::table('translations_keywords')->insert(array('id' => 41, 'keyword' => 'admin.field.email'));
        DB::table('translations_keywords')->insert(array('id' => 42, 'keyword' => 'admin.field.new_password'));
        DB::table('translations_keywords')->insert(array('id' => 43, 'keyword' => 'admin.field.repeat_password'));
        DB::table('translations_keywords')->insert(array('id' => 44, 'keyword' => 'admin.button.generate_random_password'));
        DB::table('translations_keywords')->insert(array('id' => 45, 'keyword' => 'admin.button.save_send'));
        DB::table('translations_keywords')->insert(array('id' => 46, 'keyword' => 'admin.role.administrator'));
        DB::table('translations_keywords')->insert(array('id' => 47, 'keyword' => 'admin.role.customer'));
        DB::table('translations_keywords')->insert(array('id' => 48, 'keyword' => 'admin.title.administrator.edit'));
        DB::table('translations_keywords')->insert(array('id' => 49, 'keyword' => 'admin.title.administrator.create_new'));
        DB::table('translations_keywords')->insert(array('id' => 50, 'keyword' => 'admin.field.password'));
        DB::table('translations_keywords')->insert(array('id' => 52, 'keyword' => 'admin.title.content_types'));
        DB::table('translations_keywords')->insert(array('id' => 53, 'keyword' => 'admin.table_heading.developer_title'));
        DB::table('translations_keywords')->insert(array('id' => 54, 'keyword' => 'admin.table_heading.administrator_title'));
        DB::table('translations_keywords')->insert(array('id' => 55, 'keyword' => 'admin.table_heading.handler'));
        DB::table('translations_keywords')->insert(array('id' => 56, 'keyword' => 'admin.title.edit_content_type'));
        DB::table('translations_keywords')->insert(array('id' => 57, 'keyword' => 'admin.text.child_tree_elements_types'));
        DB::table('translations_keywords')->insert(array('id' => 58, 'keyword' => 'admin.text.child_additional_element_types'));
        DB::table('translations_keywords')->insert(array('id' => 59, 'keyword' => 'admin.field.developer_title'));
        DB::table('translations_keywords')->insert(array('id' => 60, 'keyword' => 'admin.field.administrator_title'));
        DB::table('translations_keywords')->insert(array('id' => 61, 'keyword' => 'admin.field.handler'));
        DB::table('translations_keywords')->insert(array('id' => 62, 'keyword' => 'admin.title.create_new_content_type'));
        DB::table('translations_keywords')->insert(array('id' => 63, 'keyword' => 'admin.button.create_folder'));

        foreach ([$firstLanguageId, $secondLanguageId] as $languageId) {

            DB::table('translations_values')->insert(array('keyword_id' => 6, 'language_id' => $languageId, 'keyword' => 'CMS'));
            DB::table('translations_values')->insert(array('keyword_id' => 7, 'language_id' => $languageId, 'keyword' => 'Content'));
            DB::table('translations_values')->insert(array('keyword_id' => 8, 'language_id' => $languageId, 'keyword' => 'Gallery'));
            DB::table('translations_values')->insert(array('keyword_id' => 9, 'language_id' => $languageId, 'keyword' => 'Translations'));
            DB::table('translations_values')->insert(array('keyword_id' => 10, 'language_id' => $languageId, 'keyword' => 'Administrators'));
            DB::table('translations_values')->insert(array('keyword_id' => 11, 'language_id' => $languageId, 'keyword' => 'Content Types'));
            DB::table('translations_values')->insert(array('keyword_id' => 12, 'language_id' => $languageId, 'keyword' => 'Translations'));
            DB::table('translations_values')->insert(array('keyword_id' => 14, 'language_id' => $languageId, 'keyword' => 'Create'));
            DB::table('translations_values')->insert(array('keyword_id' => 15, 'language_id' => $languageId, 'keyword' => 'Save'));
            DB::table('translations_values')->insert(array('keyword_id' => 16, 'language_id' => $languageId, 'keyword' => 'Cancel'));
            DB::table('translations_values')->insert(array('keyword_id' => 17, 'language_id' => $languageId, 'keyword' => 'Edit'));
            DB::table('translations_values')->insert(array('keyword_id' => 18, 'language_id' => $languageId, 'keyword' => 'Delete'));
            DB::table('translations_values')->insert(array('keyword_id' => 19, 'language_id' => $languageId, 'keyword' => 'Keyword'));
            DB::table('translations_values')->insert(array('keyword_id' => 20, 'language_id' => $languageId, 'keyword' => 'Title'));
            DB::table('translations_values')->insert(array('keyword_id' => 21, 'language_id' => $languageId, 'keyword' => 'Status'));
            DB::table('translations_values')->insert(array('keyword_id' => 22, 'language_id' => $languageId, 'keyword' => 'Logged as:'));
            DB::table('translations_values')->insert(array('keyword_id' => 23, 'language_id' => $languageId, 'keyword' => 'Logout'));
            DB::table('translations_values')->insert(array('keyword_id' => 24, 'language_id' => $languageId, 'keyword' => 'Hidden'));
            DB::table('translations_values')->insert(array('keyword_id' => 26, 'language_id' => $languageId, 'keyword' => 'Title'));
            DB::table('translations_values')->insert(array('keyword_id' => 27, 'language_id' => $languageId, 'keyword' => 'Type'));
            DB::table('translations_values')->insert(array('keyword_id' => 28, 'language_id' => $languageId, 'keyword' => 'Add new tree item'));
            DB::table('translations_values')->insert(array('keyword_id' => 29, 'language_id' => $languageId, 'keyword' => 'Add new item'));
            DB::table('translations_values')->insert(array('keyword_id' => 30, 'language_id' => $languageId, 'keyword' => 'Visible'));
            DB::table('translations_values')->insert(array('keyword_id' => 31, 'language_id' => $languageId, 'keyword' => 'Keyword'));
            DB::table('translations_values')->insert(array('keyword_id' => 33, 'language_id' => $languageId, 'keyword' => 'Administrators'));
            DB::table('translations_values')->insert(array('keyword_id' => 34, 'language_id' => $languageId, 'keyword' => 'Email'));
            DB::table('translations_values')->insert(array('keyword_id' => 35, 'language_id' => $languageId, 'keyword' => 'Name'));
            DB::table('translations_values')->insert(array('keyword_id' => 36, 'language_id' => $languageId, 'keyword' => 'Type'));
            DB::table('translations_values')->insert(array('keyword_id' => 37, 'language_id' => $languageId, 'keyword' => 'Developer'));
            DB::table('translations_values')->insert(array('keyword_id' => 38, 'language_id' => $languageId, 'keyword' => 'Last logged at'));
            DB::table('translations_values')->insert(array('keyword_id' => 39, 'language_id' => $languageId, 'keyword' => 'Last logged IP'));
            DB::table('translations_values')->insert(array('keyword_id' => 40, 'language_id' => $languageId, 'keyword' => 'Name'));
            DB::table('translations_values')->insert(array('keyword_id' => 41, 'language_id' => $languageId, 'keyword' => 'Email'));
            DB::table('translations_values')->insert(array('keyword_id' => 42, 'language_id' => $languageId, 'keyword' => 'New password'));
            DB::table('translations_values')->insert(array('keyword_id' => 43, 'language_id' => $languageId, 'keyword' => 'Repeat password'));
            DB::table('translations_values')->insert(array('keyword_id' => 44, 'language_id' => $languageId, 'keyword' => 'Generate random password'));
            DB::table('translations_values')->insert(array('keyword_id' => 45, 'language_id' => $languageId, 'keyword' => 'Save & Send'));
            DB::table('translations_values')->insert(array('keyword_id' => 46, 'language_id' => $languageId, 'keyword' => 'Administrator'));
            DB::table('translations_values')->insert(array('keyword_id' => 47, 'language_id' => $languageId, 'keyword' => 'Customer'));
            DB::table('translations_values')->insert(array('keyword_id' => 48, 'language_id' => $languageId, 'keyword' => 'Edit administrator'));
            DB::table('translations_values')->insert(array('keyword_id' => 49, 'language_id' => $languageId, 'keyword' => 'Create administrator'));
            DB::table('translations_values')->insert(array('keyword_id' => 50, 'language_id' => $languageId, 'keyword' => 'Password'));
            DB::table('translations_values')->insert(array('keyword_id' => 52, 'language_id' => $languageId, 'keyword' => 'Content Types'));
            DB::table('translations_values')->insert(array('keyword_id' => 53, 'language_id' => $languageId, 'keyword' => 'Developer title'));
            DB::table('translations_values')->insert(array('keyword_id' => 54, 'language_id' => $languageId, 'keyword' => 'Administrator title'));
            DB::table('translations_values')->insert(array('keyword_id' => 55, 'language_id' => $languageId, 'keyword' => 'Handler'));
            DB::table('translations_values')->insert(array('keyword_id' => 56, 'language_id' => $languageId, 'keyword' => 'Edit content type'));
            DB::table('translations_values')->insert(array('keyword_id' => 57, 'language_id' => $languageId, 'keyword' => 'Child tree elements types'));
            DB::table('translations_values')->insert(array('keyword_id' => 58, 'language_id' => $languageId, 'keyword' => 'Child additional element types'));
            DB::table('translations_values')->insert(array('keyword_id' => 59, 'language_id' => $languageId, 'keyword' => 'Developer title'));
            DB::table('translations_values')->insert(array('keyword_id' => 60, 'language_id' => $languageId, 'keyword' => 'Administrator title'));
            DB::table('translations_values')->insert(array('keyword_id' => 61, 'language_id' => $languageId, 'keyword' => 'Handler'));
            DB::table('translations_values')->insert(array('keyword_id' => 62, 'language_id' => $languageId, 'keyword' => 'Create new content type'));
            DB::table('translations_values')->insert(array('keyword_id' => 63, 'language_id' => $languageId, 'keyword' => 'Create folder'));
        }
    }

}