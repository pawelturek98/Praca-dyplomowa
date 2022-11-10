import './styles/app.scss';

import 'bootstrap/scss/bootstrap.scss';

window.onload = function() {
    const addClassname = (element, classname) => {
        if(!element.classList.contains(classname)) {
            element.classList.add(classname);
        }
    }

    const showLectureFormContentInput = (inputId) => {
        let input = document.querySelector(`#${inputId}`);
        let inputs = document.querySelectorAll('.content-type-input');

        inputs.forEach(function(element, key) {
            addClassname(element, 'display-hidden')
        })

        input.classList.remove('display-hidden');
    }

    let lectureFormType = document.querySelector('#lecture_form_type');

    showLectureFormContentInput(`lecture-${lectureFormType.value}`);
    lectureFormType.addEventListener('change', function (e) {
        console.log('test');
        showLectureFormContentInput(`lecture-${this.value}`)
    });
}
