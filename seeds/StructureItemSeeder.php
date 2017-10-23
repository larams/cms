<?php


use Illuminate\Database\Seeder;

class StructureItemSeeder extends Seeder
{

    public function run()
    {
        DB::table('structure_items')->delete();
        DB::table('translation_keywords')->delete();
        DB::table('translation_values')->delete();

        $siteId = DB::table('structure_items')->insertGetId(array('parent_id' => DB::raw('NULL'), 'name' => 'Site Name', 'uri' => '', 'level' => 1, 'type_id' => 1, 'left' => 1, 'right' => 14, 'tree' => 1, 'active' => 1));
        DB::table('structure_items')->insert(array('parent_id' => DB::raw('NULL'), 'name' => 'Galerija', 'uri' => '', 'level' => 1, 'type_id' => 17, 'left' => 15, 'right' => 16, 'tree' => 1, 'active' => 1));

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

        DB::table('translation_keywords')->insert(array('id' => 6, 'keyword' => 'admin.title.cms'));
        DB::table('translation_keywords')->insert(array('id' => 7, 'keyword' => 'admin.menu.content'));
        DB::table('translation_keywords')->insert(array('id' => 8, 'keyword' => 'admin.menu.gallery'));
        DB::table('translation_keywords')->insert(array('id' => 9, 'keyword' => 'admin.menu.translations'));
        DB::table('translation_keywords')->insert(array('id' => 10, 'keyword' => 'admin.menu.administrators'));
        DB::table('translation_keywords')->insert(array('id' => 11, 'keyword' => 'admin.menu.content_types'));
        DB::table('translation_keywords')->insert(array('id' => 12, 'keyword' => 'admin.title.translations'));
        DB::table('translation_keywords')->insert(array('id' => 31, 'keyword' => 'admin.text.keyword'));
        DB::table('translation_keywords')->insert(array('id' => 14, 'keyword' => 'admin.button.create'));
        DB::table('translation_keywords')->insert(array('id' => 15, 'keyword' => 'admin.button.save'));
        DB::table('translation_keywords')->insert(array('id' => 16, 'keyword' => 'admin.button.cancel'));
        DB::table('translation_keywords')->insert(array('id' => 17, 'keyword' => 'admin.button.edit'));
        DB::table('translation_keywords')->insert(array('id' => 18, 'keyword' => 'admin.button.delete'));
        DB::table('translation_keywords')->insert(array('id' => 19, 'keyword' => 'admin.table_heading.keyword'));
        DB::table('translation_keywords')->insert(array('id' => 20, 'keyword' => 'admin.table_heading.title'));
        DB::table('translation_keywords')->insert(array('id' => 21, 'keyword' => 'admin.table_heading.status'));
        DB::table('translation_keywords')->insert(array('id' => 22, 'keyword' => 'admin.text.logged_as'));
        DB::table('translation_keywords')->insert(array('id' => 23, 'keyword' => 'admin.menu.logout'));
        DB::table('translation_keywords')->insert(array('id' => 24, 'keyword' => 'admin.button.hidden'));
        DB::table('translation_keywords')->insert(array('id' => 26, 'keyword' => 'admin.field.title'));
        DB::table('translation_keywords')->insert(array('id' => 27, 'keyword' => 'admin.field.type'));
        DB::table('translation_keywords')->insert(array('id' => 28, 'keyword' => 'admin.button.add_new_tree_item'));
        DB::table('translation_keywords')->insert(array('id' => 29, 'keyword' => 'admin.button.add_new_item'));
        DB::table('translation_keywords')->insert(array('id' => 30, 'keyword' => 'admin.button.visible'));
        DB::table('translation_keywords')->insert(array('id' => 33, 'keyword' => 'admin.title.administrator.list'));
        DB::table('translation_keywords')->insert(array('id' => 34, 'keyword' => 'admin.table_heading.email'));
        DB::table('translation_keywords')->insert(array('id' => 35, 'keyword' => 'admin.table_heading.name'));
        DB::table('translation_keywords')->insert(array('id' => 36, 'keyword' => 'admin.table_heading.type'));
        DB::table('translation_keywords')->insert(array('id' => 37, 'keyword' => 'admin.role.developer'));
        DB::table('translation_keywords')->insert(array('id' => 38, 'keyword' => 'admin.table_heading.last_logged_at'));
        DB::table('translation_keywords')->insert(array('id' => 39, 'keyword' => 'admin.table_heading.last_logged_ip'));
        DB::table('translation_keywords')->insert(array('id' => 40, 'keyword' => 'admin.field.name'));
        DB::table('translation_keywords')->insert(array('id' => 41, 'keyword' => 'admin.field.email'));
        DB::table('translation_keywords')->insert(array('id' => 42, 'keyword' => 'admin.field.new_password'));
        DB::table('translation_keywords')->insert(array('id' => 43, 'keyword' => 'admin.field.repeat_password'));
        DB::table('translation_keywords')->insert(array('id' => 44, 'keyword' => 'admin.button.generate_random_password'));
        DB::table('translation_keywords')->insert(array('id' => 45, 'keyword' => 'admin.button.save_send'));
        DB::table('translation_keywords')->insert(array('id' => 46, 'keyword' => 'admin.role.administrator'));
        DB::table('translation_keywords')->insert(array('id' => 47, 'keyword' => 'admin.role.customer'));
        DB::table('translation_keywords')->insert(array('id' => 48, 'keyword' => 'admin.title.administrator.edit'));
        DB::table('translation_keywords')->insert(array('id' => 49, 'keyword' => 'admin.title.administrator.create_new'));
        DB::table('translation_keywords')->insert(array('id' => 50, 'keyword' => 'admin.field.password'));
        DB::table('translation_keywords')->insert(array('id' => 52, 'keyword' => 'admin.title.content_types'));
        DB::table('translation_keywords')->insert(array('id' => 53, 'keyword' => 'admin.table_heading.developer_title'));
        DB::table('translation_keywords')->insert(array('id' => 54, 'keyword' => 'admin.table_heading.administrator_title'));
        DB::table('translation_keywords')->insert(array('id' => 55, 'keyword' => 'admin.table_heading.handler'));
        DB::table('translation_keywords')->insert(array('id' => 56, 'keyword' => 'admin.title.edit_content_type'));
        DB::table('translation_keywords')->insert(array('id' => 57, 'keyword' => 'admin.text.child_tree_elements_types'));
        DB::table('translation_keywords')->insert(array('id' => 58, 'keyword' => 'admin.text.child_additional_element_types'));
        DB::table('translation_keywords')->insert(array('id' => 59, 'keyword' => 'admin.field.developer_title'));
        DB::table('translation_keywords')->insert(array('id' => 60, 'keyword' => 'admin.field.administrator_title'));
        DB::table('translation_keywords')->insert(array('id' => 61, 'keyword' => 'admin.field.handler'));
        DB::table('translation_keywords')->insert(array('id' => 62, 'keyword' => 'admin.title.create_new_content_type'));
        DB::table('translation_keywords')->insert(array('id' => 63, 'keyword' => 'admin.button.create_folder'));
        DB::table('translation_keywords')->insert(array('id' => 64, 'keyword' => 'admin.title.please_signin'));
        DB::table('translation_keywords')->insert(array('id' => 65, 'keyword' => 'admin.button.signin'));

        foreach ([$firstLanguageId, $secondLanguageId] as $languageId) {

            DB::table('translation_values')->insert(array('keyword_id' => 6, 'language_id' => $languageId, 'value' => 'CMS'));
            DB::table('translation_values')->insert(array('keyword_id' => 7, 'language_id' => $languageId, 'value' => 'Content'));
            DB::table('translation_values')->insert(array('keyword_id' => 8, 'language_id' => $languageId, 'value' => 'Gallery'));
            DB::table('translation_values')->insert(array('keyword_id' => 9, 'language_id' => $languageId, 'value' => 'Translations'));
            DB::table('translation_values')->insert(array('keyword_id' => 10, 'language_id' => $languageId, 'value' => 'Administrators'));
            DB::table('translation_values')->insert(array('keyword_id' => 11, 'language_id' => $languageId, 'value' => 'Content Types'));
            DB::table('translation_values')->insert(array('keyword_id' => 12, 'language_id' => $languageId, 'value' => 'Translations'));
            DB::table('translation_values')->insert(array('keyword_id' => 14, 'language_id' => $languageId, 'value' => 'Create'));
            DB::table('translation_values')->insert(array('keyword_id' => 15, 'language_id' => $languageId, 'value' => 'Save'));
            DB::table('translation_values')->insert(array('keyword_id' => 16, 'language_id' => $languageId, 'value' => 'Cancel'));
            DB::table('translation_values')->insert(array('keyword_id' => 17, 'language_id' => $languageId, 'value' => 'Edit'));
            DB::table('translation_values')->insert(array('keyword_id' => 18, 'language_id' => $languageId, 'value' => 'Delete'));
            DB::table('translation_values')->insert(array('keyword_id' => 19, 'language_id' => $languageId, 'value' => 'Keyword'));
            DB::table('translation_values')->insert(array('keyword_id' => 20, 'language_id' => $languageId, 'value' => 'Title'));
            DB::table('translation_values')->insert(array('keyword_id' => 21, 'language_id' => $languageId, 'value' => 'Status'));
            DB::table('translation_values')->insert(array('keyword_id' => 22, 'language_id' => $languageId, 'value' => 'Logged as:'));
            DB::table('translation_values')->insert(array('keyword_id' => 23, 'language_id' => $languageId, 'value' => 'Logout'));
            DB::table('translation_values')->insert(array('keyword_id' => 24, 'language_id' => $languageId, 'value' => 'Hidden'));
            DB::table('translation_values')->insert(array('keyword_id' => 26, 'language_id' => $languageId, 'value' => 'Title'));
            DB::table('translation_values')->insert(array('keyword_id' => 27, 'language_id' => $languageId, 'value' => 'Type'));
            DB::table('translation_values')->insert(array('keyword_id' => 28, 'language_id' => $languageId, 'value' => 'Add new tree item'));
            DB::table('translation_values')->insert(array('keyword_id' => 29, 'language_id' => $languageId, 'value' => 'Add new item'));
            DB::table('translation_values')->insert(array('keyword_id' => 30, 'language_id' => $languageId, 'value' => 'Visible'));
            DB::table('translation_values')->insert(array('keyword_id' => 31, 'language_id' => $languageId, 'value' => 'Keyword'));
            DB::table('translation_values')->insert(array('keyword_id' => 33, 'language_id' => $languageId, 'value' => 'Administrators'));
            DB::table('translation_values')->insert(array('keyword_id' => 34, 'language_id' => $languageId, 'value' => 'Email'));
            DB::table('translation_values')->insert(array('keyword_id' => 35, 'language_id' => $languageId, 'value' => 'Name'));
            DB::table('translation_values')->insert(array('keyword_id' => 36, 'language_id' => $languageId, 'value' => 'Type'));
            DB::table('translation_values')->insert(array('keyword_id' => 37, 'language_id' => $languageId, 'value' => 'Developer'));
            DB::table('translation_values')->insert(array('keyword_id' => 38, 'language_id' => $languageId, 'value' => 'Last logged at'));
            DB::table('translation_values')->insert(array('keyword_id' => 39, 'language_id' => $languageId, 'value' => 'Last logged IP'));
            DB::table('translation_values')->insert(array('keyword_id' => 40, 'language_id' => $languageId, 'value' => 'Name'));
            DB::table('translation_values')->insert(array('keyword_id' => 41, 'language_id' => $languageId, 'value' => 'Email'));
            DB::table('translation_values')->insert(array('keyword_id' => 42, 'language_id' => $languageId, 'value' => 'New password'));
            DB::table('translation_values')->insert(array('keyword_id' => 43, 'language_id' => $languageId, 'value' => 'Repeat password'));
            DB::table('translation_values')->insert(array('keyword_id' => 44, 'language_id' => $languageId, 'value' => 'Generate random password'));
            DB::table('translation_values')->insert(array('keyword_id' => 45, 'language_id' => $languageId, 'value' => 'Save & Send'));
            DB::table('translation_values')->insert(array('keyword_id' => 46, 'language_id' => $languageId, 'value' => 'Administrator'));
            DB::table('translation_values')->insert(array('keyword_id' => 47, 'language_id' => $languageId, 'value' => 'Customer'));
            DB::table('translation_values')->insert(array('keyword_id' => 48, 'language_id' => $languageId, 'value' => 'Edit administrator'));
            DB::table('translation_values')->insert(array('keyword_id' => 49, 'language_id' => $languageId, 'value' => 'Create administrator'));
            DB::table('translation_values')->insert(array('keyword_id' => 50, 'language_id' => $languageId, 'value' => 'Password'));
            DB::table('translation_values')->insert(array('keyword_id' => 52, 'language_id' => $languageId, 'value' => 'Content Types'));
            DB::table('translation_values')->insert(array('keyword_id' => 53, 'language_id' => $languageId, 'value' => 'Developer title'));
            DB::table('translation_values')->insert(array('keyword_id' => 54, 'language_id' => $languageId, 'value' => 'Administrator title'));
            DB::table('translation_values')->insert(array('keyword_id' => 55, 'language_id' => $languageId, 'value' => 'Handler'));
            DB::table('translation_values')->insert(array('keyword_id' => 56, 'language_id' => $languageId, 'value' => 'Edit content type'));
            DB::table('translation_values')->insert(array('keyword_id' => 57, 'language_id' => $languageId, 'value' => 'Child tree elements types'));
            DB::table('translation_values')->insert(array('keyword_id' => 58, 'language_id' => $languageId, 'value' => 'Child additional element types'));
            DB::table('translation_values')->insert(array('keyword_id' => 59, 'language_id' => $languageId, 'value' => 'Developer title'));
            DB::table('translation_values')->insert(array('keyword_id' => 60, 'language_id' => $languageId, 'value' => 'Administrator title'));
            DB::table('translation_values')->insert(array('keyword_id' => 61, 'language_id' => $languageId, 'value' => 'Handler'));
            DB::table('translation_values')->insert(array('keyword_id' => 62, 'language_id' => $languageId, 'value' => 'Create new content type'));
            DB::table('translation_values')->insert(array('keyword_id' => 63, 'language_id' => $languageId, 'value' => 'Create folder'));
            DB::table('translation_values')->insert(array('keyword_id' => 64, 'language_id' => $languageId, 'value' => 'Please sign-in'));
            DB::table('translation_values')->insert(array('keyword_id' => 65, 'language_id' => $languageId, 'value' => 'Sign-in'));
        }
    }

}