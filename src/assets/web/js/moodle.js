/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 * @package   open20\amos-moodle
 * @author    Aria S.p.A. <protocollo@pec.ariaspa.it>
 * @license   GNU General Public License v3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @link      https://www.ariaspa.it/
 *
 * This file is part of OPEN 2.0.
 *
 * OPEN 2.0 is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OPEN 2.0 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OPEN 2.0. If not, see <https://www.gnu.org/licenses/>.
 */

$(document).ready(function () {
    $('#lesson-info').on('show.bs.modal', function (event) {
            var link = $(event.relatedTarget); // link that triggered the modal
            var lessonId = link.data('lesson-id'); // Extract info from data-* attributes
            var lessonName = link.data('lesson-name');
            var lessonInstance = link.data('lesson-instance');
            var lessonModname = link.data('lesson-modname');
            var modal = $(this);

            modal.find('#modal-title').text(lessonName);

            if (lessonModname == "scorm") {
                lessonUrl = '/moodle/lesson/lesson-detail?lessonId=' + lessonId; // usato nella callback
                modal.find('.modal-body').load(lessonUrl);
            } else if (lessonModname == "certificate") {
                modal.find('.modal-body').load('/moodle/lesson/certificate-detail?certificateId=' + lessonInstance);
            } else if (lessonModname == "customcert") {
                modal.find('.modal-body').load('/moodle/lesson/customcert-detail?lessonId=' + lessonId + 'certificateId=' + lessonInstance);
            } else if (lessonModname == "quiz") {
                modal.find('.modal-body').load('/moodle/lesson/quiz-detail?lessonId=' + lessonId + '&quizId=' + lessonInstance);
            } else if (lessonModname == "page") {
                modal.find('.modal-body').load('/moodle/lesson/page-detail?lessonId=' + lessonId + '&pageId=' + lessonInstance);
            } else if (lessonModname == "questionnaire") {
                modal.find('.modal-body').load('/moodle/lesson/questionnaire-detail?lessonId=' + lessonId + '&questionnaireId=' + lessonInstance);
            } else if (lessonModname == "resource") {
                modal.find('.modal-body').load('/moodle/lesson/resource-detail?lessonId=' + lessonId + '&resourceId=' + lessonInstance);
            }
        })
    .on('hidden.bs.modal', function () {
        location.reload(); // quando viene chiusa, ricarica la pagina padre
    });

    $("body").on('click', "#btn-get-resource", function(e) {
        e.preventDefault();
        
        var href = $(this).attr('href');
        opened = window.open(href);
        
        $(this).text('Chiudi');
        this.id = "btn-close-modal";
    });
    
    $("body").on('click', "#btn-close-modal", function(e) {
        e.preventDefault();

        $("#lesson-info .close").click()
    });
    
});
