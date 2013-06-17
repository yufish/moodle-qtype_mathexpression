<?php

/**
 * *************************************************************************
 * *                            MathExpression                            **
 * *************************************************************************
 * @package     question                                                  **
 * @subpackage  mathexpression                                            **
 * @name        MathExpression                                            **
 * @copyright   oohoo.biz                                                 **
 * @link        http://oohoo.biz                                          **
 * @author      Raymond Wainman (wainman@ualberta.ca)                     **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */

defined('MOODLE_INTERNAL') || die();


class backup_qtype_mathexpression_plugin extends backup_qtype_plugin {

    /**
     * Returns the qtype information to attach to question element
     */
    protected function define_question_plugin_structure() {

        // Define the virtual plugin element with the condition to fulfill.
        $plugin = $this->get_plugin_element(null, '../../qtype', 'mathexpression');

        // Create one standard named plugin element (the visible container).
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        // Connect the visible container ASAP.
        $plugin->add_child($pluginwrapper);

        // Now create the qtype own structures.
        $options = new backup_nested_element('options', array('id'), array(
                'buttonlist', 'comparetype', 'answer_mathml'));

        // Now the own qtype tree.
        $pluginwrapper->add_child($options);

        // Set source to populate the data.
        $options->set_source_table('qtype_mathexpression_options',
                array('questionid' => backup::VAR_PARENTID));

        // Excludes
        $excludes = new backup_nested_element('excludes');
        $pluginwrapper->add_child($excludes);

        $exclude = new backup_nested_element('exclude', array('id'), array(
                'answer', 'answer_mathml'));
        $excludes->add_child($exclude);

        $exclude->set_source_table('qtype_mathexpression_exclude', array('questionid' => backup::VAR_PARENTID));

        // Variables
        $variables = new backup_nested_element('vars');
        $pluginwrapper->add_child($variables);

        $var = new backup_nested_element('var', array('id'), array(
                'variable', 'variable_mathml'));
        $variables->add_child($var);

        $var->set_source_table('qtype_mathexpression_vars', array('questionid' => backup::VAR_PARENTID));

        return $plugin;
    }

}
