
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
        selects: []
    },
    mounted() {
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
        filterData: async function (userId, url) {
            console.log({userId, url})
            this.searchEnable = true;
            url = url + '/incluyeme/include/verifications.php';
            jQuery("#filterApplicants").modal('hide');//ocultamos el modal
            jQuery('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
            jQuery('.modal-backdrop').remove();//eliminamos el backdrop del modal
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
                jobs: this.jobs,
                city: this.city,
                keyPhrase: this.keyPhrase,
                course: this.course,
                name: this.name,
                lastName: this.lastName,
                oral: this.oral,
                idioms: this.idioms,
                education: this.education,
                description: this.description,
                residence: this.residence,
                letter: this.letter,
                email: this.email,
                motriz: this.motriz,
                auditive: this.auditive,
                visual: this.visual,
                visceral: this.visceral,
                intelectual: this.intelectual,
                psiquica: this.psiquica,
                habla: this.habla,
                ninguna: this.ninguna,
                id: userId
            };
            if (this.status.length) {
                data.status = this.status
            }
            if (this.selects.length) {
                data.selects = this.selects
            }
            let request = await jQuery.ajax({
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
                    requestChange =  request.message;
                    request.message =[];
                    request.message.push(requestChange[1]);
                }
                if (request.message.length) {
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
                            request.message[i].read = ' #Desestimado';
                        }
                    }
                    this.message = request.message;
                    console.log(this.message)
                } else {
                    this.message = 'No hay resultados';
                }
            }
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
        }
    }
});