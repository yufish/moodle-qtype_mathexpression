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

class qtype_mathexpression extends question_type {
    /**
     * Saves question-type specific options
     *
     * @override
     * @param object $question  This holds the information from the editing form, it is not a
     *      standard question object
     * @return object $result->error or $result->noticeyesno or $result->notice
     */
    public function save_question_options($question) {
        global $DB;
        $result = new stdClass();

        // Remove old answer
        $oldanswers = $DB->delete_records('question_answers', array('question' => $question->id));

        // Insert new answer
        $answer = new stdClass();
        $answer->question = $question->id;
        $answer->answer = trim($question->answer['text']);
        $answer->answerformat = $question->answer['format'];
        $answer->fraction = 1;
        $answer->feedback = '';
        $answer->feedbackformat = 0;
        $answer->id = $DB->insert_record('question_answers', $answer);

        $parentresult = parent::save_question_options($question);
        if ($parentresult !== null) {
            // Parent function returns null if all is OK.
            return $parentresult;
        }
    }
    
    /**
     * Initialises the custom fields within the {@code qtype_mathexpression_question} class.
     *
     * @override
     * @param question_definition $question the question_definition we are creating
     * @param object $questiondata the question data loaded from the database
     */
    protected function initialise_question_instance(question_definition $question, $questiondata) {
        parent::initialise_question_instance($question, $questiondata);

        $answer = array_shift($questiondata->options->answers);
        $question->correctanswer = $answer->answer;
    }
}