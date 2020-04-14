Vue.config.ignoredElements = ['x-incluyeme']
let filterApplicants = new Vue({
    el: '#incluyeme-wpjb',
    data: {
        message: false,
        searchEnable: false,
        jobs: null,
        city: null,
        keyPhrase: null,
        course: null,
        name: null,
        lastName: null,
        oral: null,
        idioms: null,
        education: null,
        description: null,
        residence: null,
        letter: null,
        email: null,
        leido: false,
        desestimado: false,
        preseleccionado: false,
        seleccionado: false,
        motriz: false,
        auditive: false,
        visual: false,
        visceral: false,
        intelectual: false,
        psiquica: false,
        habla: false,
        ninguna: false,
        status: [],
        selects: [],
        ult: false,
        img: false,
        url: '',
        selected: 1
    },
    mounted() {
        var incluyemeContent = document.getElementById("content");
        var incluyemeSidebar = document.getElementById("sidebar");
        var incluyemeTitle = document.getElementsByClassName("container  right-sidebar  no-vc  right-sidebar  has-title no-vc");
        if (incluyemeContent && incluyemeSidebar && incluyemeTitle) {
            incluyemeContent.classList.add("col-9");
            incluyemeSidebar.classList.add("col");
            incluyemeSidebar.classList.add("ml-5");
            incluyemeTitle[0].className += " row";
        }
        this.observer = new MutationObserver(mutations => {
            for (const m of mutations) {
                const newValue = m.target.getAttribute(m.attributeName);
                this.$nextTick(() => {
                    this.onClassChange(newValue, m.oldValue);
                });
            }
        });

        this.observer.observe(this.$refs.filterApplicants, {
            attributes: true,
            attributeOldValue: true,
            attributeFilter: ['class'],
        });
    },
    beforeDestroy() {
        this.observer.disconnect();
    },
    methods: {
        filterData: async function (img, userId, url, validate = false) {
            this.img = img;
            this.searchEnable = true;
            url = url + '/incluyeme/include/verifications.php';
            this.url = url;
            jQuery("#filterApplicants").modal('hide');
            jQuery('body').removeClass('modal-open');
            jQuery('.modal-backdrop').remove();
            this.message = 'Buscando...';
            const statuses = (val, number) => {
                if (val) {
                    this.status.push(number);
                }
            };
            const select = (val, disca) => {
                if (val) {
                    this.selects.push(disca);
                }
            };
            statuses(this.leido, 3);
            statuses(this.preseleccionado, 4);
            statuses(this.seleccionado, 2);
            statuses(this.desestimado, 0);
            select(this.visceral, 'Visceral');
            select(this.visual, 'Visual');
            select(this.auditive, 'Auditiva');
            select(this.habla, 'Habla');
            select(this.psiquica, 'Psiquica');
            select(this.ninguna, 'Ninguna');
            select(this.intelectual, 'Intelectual');
            select(this.motriz, 'Motriz');
            let data = {
                id: userId
            };
            this.ult = data;
            if (this.keyPhrase !== null && this.keyPhrase !== '') {
                data.keyPhrase = this.keyPhrase
            }
            if (validate) {
                data = this.ult
            }
            if (this.status.length) {
                data.status = this.status
            }
            if (this.selects.length) {
                data.selects = this.selects
            }
            if (this.jobs !== null && this.jobs !== '0') {
                data.jobs = this.jobs
            }
            if (this.city !== null && data.city !== '') {
                data.city = this.city;
            }
            if (this.course !== null && data.course !== '') {
                data.course = this.course;
            }
            if (this.name !== null && data.name !== '') {
                data.name = this.name;
            }
            if (this.lastName !== null && data.lastName !== '') {
                data.lastName = this.lastName;
            }
            if (this.email !== null && data.email !== '') {
                data.email = this.email;
            }
            if (this.residence !== null && data.residence !== '') {
                data.residence = this.residence;
            }
            if (this.letter !== null && data.letter !== '') {
                data.letter = this.letter;
            }
            if (this.description !== null && data.description !== '') {
                data.description = this.description;
            }
            if (this.education !== null && data.education !== '') {
                data.education = this.education;
            }if (this.idioms !== null && data.idioms !== '') {
                data.idioms = this.idioms;
            }
            let
                request = await jQuery.ajax({
                    url: url,
                    data: data,
                    type: 'POST',
                    dataType: 'json'
                }).done(success => {
                    return success
                }).fail((error) => {
                    return 'Disculpe, hay un problema';
                });
            if (typeof request === 'string') {
                this.message = request
            } else {
                if (!Array.isArray(request.message)) {
                    requestChange = request.message;
                    request.message = [];
                    request.message.push(requestChange[1]);
                }
                if (request.message.length) {
                    let k = function removeDuplicates(originalArray, prop) {
                        var newArray = [];
                        var lookupObject = {};

                        for (var i in originalArray) {
                            lookupObject[originalArray[i][prop]] = originalArray[i];
                        }

                        for (i in lookupObject) {
                            newArray.push(lookupObject[i]);
                        }
                        return newArray;
                    };
                    request.message = k(request.message, 'resume_id');
                    for (let i in request.message) {
                        request.message[i].applicant_status = Number(request.message[i].applicant_status);
                        if (request.message[i].applicant_status === 3) {
                            request.message[i].color = '1px solid black';
                            request.message[i].read = '#Leido'
                        } else if (request.message[i].applicant_status === 1) {
                            request.message[i].color = '1px solid blue';
                            request.message[i].read = '#Nuevo'
                        } else if (request.message[i].applicant_status === 4) {
                            request.message[i].color = '1px solid orange';
                            request.message[i].read = '#Preseleccionado'
                        } else if (request.message[i].applicant_status === 2) {
                            request.message[i].color = '1px solid green';
                            request.message[i].read = '#Seleccionado'
                        } else if (request.message[i].applicant_status === 0) {
                            request.message[i].color = '1px solid red';
                            request.message[i].read = '#Desestimado';
                        }
                    }
                    this.message = request.message;
                } else {
                    this.message = 'No hay resultados';
                }
            }
        },
        changeFav: async function (userId, url, val, resume) {
            let urls = url + '/incluyeme/include/verifications.php';

            let data = {
                id: userId, val, resume, changes: 25
            };
            await jQuery.ajax({
                url: urls,
                data: data,
                type: 'POST',
                dataType: 'json'
            }).done(success => {
                return success
            }).fail((error) => {
                return 'Disculpe, hay un problema';
            });
            this.filterData(this.img, userId, url, true);
        },
        openPDF(PDF) {
            window.open(PDF);
            return false;
        },
        onClassChange(classAttrValue) {
            const classList = classAttrValue.split(' ');
            if (classList.includes('show')) {
                this.searchEnable = false;
                this.jobs = null;
                this.city = null;
                this.keyPhrase = null;
                this.course = null;
                this.name = null;
                this.lastName = null;
                this.oral = null;
                this.idioms = null;
                this.education = null;
                this.description = null;
                this.residence = null;
                this.letter = null;
                this.email = null;
                this.motriz = false;
                this.auditive = false;
                this.visual = false;
                this.visceral = false;
                this.intelectual = false;
                this.psiquica = false;
                this.habla = false;
                this.ninguna = false;
                this.leido = false;
                this.desestimado = null;
                this.preseleccionado = null;
                this.seleccionado = null;
                this.status = [];
                this.selects = [];
            }
        },
        onChange: async function (userId, status, resume) {
            let message = 'Estatus desconocido';
            if (status === 3) {
                message = '#Leido'
            } else if (status === 1) {
                message = '#Nuevo'
            } else if (status === 4) {
                message = '#Preseleccionado'
            } else if (status === 2) {
                message = '#Seleccionado'
            } else if (status === 0) {
                message = '#Desestimado';
            }
            let data = {
                id: userId,
                resume: resume, statusChange: status,
                read: true,
                jobs: this.jobs
            };
            await jQuery.ajax({
                url: this.url,
                data: data,
                type: 'POST',
                dataType: 'json'
            }).done(success => {
                iziToast.success({
                    title: 'OK',
                    message: 'Usuario marcado como <b>' + message + '</b>',
                    progressBarColor: 'rgb(0, 255, 184)',
                    buttons: [
                        ['<button>Cerrar</button>', function (instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOutUp',
                                onClosing: function (instance, toast, closedBy) {
                                }
                            }, toast, 'buttonName');
                        }]
                    ],
                });
            }).fail((error) => {
                alert('Disculpe, hay un problema');
            });
            this.filterData(this.img, userId, this.url, true);
        }
    }
});