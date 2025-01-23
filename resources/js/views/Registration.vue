<template>
  <div class>
    <ValidationObserver ref="form" v-slot="{ handleSubmit,reset,valid }">
      <form
          id="myform"
          action="/az/signup.html"
          method="post"
          @submit.prevent="handleSubmit(onSubmit(valid))"
          @reset.prevent="reset"
      >
        <div class="register-label-50 first-sm">
          <div class="def-label field-signupform-name required has-success">
            <validation-provider rules="required" v-slot="{ errors }">
              <label
                  class="control-label"
                  for="signupform-name"
                  :class="{error:errors[0]}"
              >{{ errors[0] ? langs.input_name_error_require : langs.input_name }}</label>
              <input
                  id="signupform-name"
                  type="text"
                  :placeholder="langs.input_name"
                  :name="langs.input_name"
                  autocomplete="off"
                  aria-required="true"
                  aria-invalid="false"
                  v-model="user.name"
              />
            </validation-provider>
          </div>
          <div class="def-label field-signupform-surname required">
            <validation-provider rules="required" v-slot="{ errors }">
              <label
                  class="control-label"
                  for="signupform-surname"
                  :class="{error:errors[0]}"
              >{{ errors[0] ? langs.input_surname_error_require : langs.input_surname }}</label>
              <input
                  type="text"
                  id="signupform-surname"
                  class="form-control"
                  :name="langs.input_surname"
                  :placeholder="langs.input_surname"
                  autocomplete="off"
                  aria-required="true"
                  v-model="user.surname"
              />
            </validation-provider>
          </div>
        </div>

        <div class="def-label field-signupform-email required">
          <validation-provider rules="required|email" v-slot="{ errors }">
            <label
                class="control-label"
                for="signupform-email"
                :class="{error:errors[0] || inputErrors.Email.is}"
            >{{ errors[0] ? langs.input_email_error_require : (inputErrors.Email.is ? inputErrors.Email.content : langs.input_email) }}</label>
            <input
                type="text"
                id="signupform-email"
                class="form-control"
                :name="langs.input_email"
                :placeholder="langs.input_email"
                autocomplete="off"
                myid="Email"
                aria-required="true"
                aria-invalid="true"
                v-model="user.email"
            />
          </validation-provider>
        </div>
        <div class="def-label field-signupform-phone_number">
          <validation-provider rules="required" v-slot="{ errors }">
            <label
                class="control-label"
                for="signupform-phone_number"
                :class="{error:errors[0] || inputErrors.phone1.is}"
            >{{ errors[0] ? langs.input_phone1_error_require : (inputErrors.phone1.is ? inputErrors.phone1.content : langs.input_phone1) }}</label>
            <input
                type="tel"
                id="signupform-phone_number"
                :name="langs.input_phone1"
                myid="phone1"
                placeholder="055-555-55-55"
                aria-required="true"
                aria-invalid="true"
                v-mask="'(###)-###-##-##'"
                minlength="15"
                v-model="user.phone1"
            />
          </validation-provider>
        </div>

        <div class="def-label field-signupform-phone_number2">
          <validation-provider rules v-slot="{ errors }">
            <label
                class="control-label"
                for="signupform-phone_number2"
                :class="{error:errors[0] || inputErrors.phone2.is}"
            >{{ errors[0] ? langs.input_phone2_error_require : (inputErrors.phone2.is ? inputErrors.phone2.content : langs.input_phone2) }}</label>
            <input
                type="text"
                id="signupform-phone_number2"
                :name="langs.input_phone2"
                placeholder="055-555-55-55"
                v-mask="'(###)-###-##-##'"
                minlength="15"
                myid="phone2"
                aria-required="true"
                aria-invalid="true"
                v-model="user.phone2"
            />
          </validation-provider>
        </div>
        <div class="register-label-50 first-sm datepicker-input">
          <div class="def-label field-signupform-birthday required">
            <validation-provider rules="required" v-slot="{ errors }">
              <label
                  class="control-label"
                  for="signupform-birthday"
                  :class="{error:errors[0]}"
              >{{ errors[0] ? langs.input_birthday_error_require : langs.input_birthday }}</label>
              <!--                            <date-picker placeholder="30/02/1992" v-model="user.birthday" name="Doğum tarixi"-->
              <!--                                         id="signupform-birthday"></date-picker>-->
              <input
                  type="date"
                  id="signupform-birthday"
                  :max="`${myYear+'-12-31'}`"
                  :name="langs.input_birthday"
                  placeholder="30/02/1992"
                  class="hasDatepicker"
                  v-model="user.birthday"
                  @change="val"
              />
            </validation-provider>
          </div>

          <div class="def-label field-signupform-user_lang">
            <validation-provider rules="required" v-slot="{ errors }">
              <label
                  class="control-label"
                  for="signupform-user_lang"
                  :class="{error:errors[0]}"
              >{{ errors[0] ? langs.input_language_error_require : langs.input_language }}</label>
              <v-select
                  :placeholder="langs.input_language"
                  value.sync="user.language"
                  :name="langs.input_language"
                  id="signupform-user_lang"
                  v-model="user.language"
                  :options="['AZ', 'EN','RU']"
              ></v-select>
              <input type="hidden" v-model="user.language" :name="langs.input_language" />
            </validation-provider>
          </div>
        </div>

        <div class="register-label-50 city-selection first-sm">
          <div class="def-label field-signupform-city">
            <validation-provider rules="required" v-slot="{ errors }">
              <label
                  class="control-label"
                  for="signupform-city"
                  :class="{error:errors[0]}"
              >{{ errors[0] ? langs.input_city_error_require : langs.input_city }}</label>
              <v-select
                  :placeholder="langs.input_city"
                  value.sync="user.city"
                  :name="langs.input_city"
                  id="signupform-city"
                  v-model="user.city"
                  :options="cities"
                  :reduce="cities => cities.name"
                  label="name"
              ></v-select>
              <input type="hidden" v-model="user.city" name="Şəhər" />
            </validation-provider>
          </div>
        </div>

        <div class="def-label field-signupform-address">
          <!--          <validation-provider rules="required" v-slot="{ errors }">-->
          <!--<label
              class="control-label"
              for="signupform-address"
              :class="{error:errors[0]}"
          >{{ errors[0] ? langs.input_address_error_require : langs.input_address }}</label>-->
          <label class="control-label" id="address_label"
                 for="signupform-address" style="color:white;">{{ langs.input_address }}</label>
          <input
              type="text"
              id="signupform-address"
              class="form-control"
              :name="langs.input_address"
              :placeholder="langs.input_address"
              required
          />
          <input type="text" hidden name="location_latitude" id="location_latitude" />
          <input type="text" hidden name="location_longitude" id="location_longitude" />
          <!--          </validation-provider>-->
        </div>
        <div class="register-label-part">
          <div class="def-label field-signupform-document_series">
            <validation-provider rules="required|alpha" v-slot="{ errors }">
              <label
                  class="control-label"
                  for="signupform-document_series"
                  :class="{error:errors[0]}"
              >{{ errors[0] ? langs.input_passport_series_error_require : langs.input_passport_series }}</label>
              <v-select
                  value.sync="user.passport_series"
                  class="seria"
                  :name="langs.input_passport_series"
                  :placeholder="langs.input_passport_series"
                  id="signupform-document_series"
                  v-model="user.passport_series"
                  :options="['AA', 'AZE','MYI','DYI','VOEN']"
                  @input="changeOnVoen"
              ></v-select>
              <input type="hidden" v-model="user.passport_series" name="Seria" />
            </validation-provider>
          </div>

          <div class="def-label field-signupform-document_number">
            <validation-provider rules="required|numeric" v-slot="{ errors }">
              <label
                  class="control-label"
                  for="signupform-document_number"
                  :class="{error:errors[0] || inputErrors.passport_number.is}"
              >{{ errors[0] ? senedError : (inputErrors.passport_number.is ? inputErrors.passport_number.content : langs.input_passport_no) }}</label>
              <input
                  type="number"
                  id="signupform-document_number"
                  class="form-control"
                  :name="langs.input_passport_no"
                  placeholder="12345678"
                  autocomplete="off"
                  aria-required="true"
                  myid="passport_number"
                  :minlength="senedLength"
                  :maxlength="senedLength"
                  v-model="user.passport_number"
              />
            </validation-provider>
          </div>
        </div>

        <div class="example-main">
          <div class="def-label field-signupform-document_fin">
            <validation-provider :rules=" `${user.passport_series!=='VOEN'?'required':''}`" v-slot="{ errors }">
              <label
                  class="control-label"
                  for="signupform-document_fin"
                  :class="{ error: ((errors[0] ) ||inputErrors.passport_fin.is)}"
              >{{ (errors[0]) ? finError : (inputErrors.passport_fin.is ? inputErrors.passport_fin.content : langs.input_passport_fin) }}</label>
              <input
                  type="text"
                  id="signupform-document_fin"
                  class="form-control"
                  :name="langs.input_passport_fin"
                  autocomplete="off"
                  :minlength="finLength"
                  :maxlength="finLength"
                  placeholder="A12345B"
                  aria-required="true"
                  myid="passport_fin"
                  :disabled="user.passport_series==='VOEN'"
                  v-model="user.passport_fin"
              />
            </validation-provider>
          </div>
          <a @click="image=!image" class="example-img" title>{{ langs.input_passport_modal_button }}</a>
        </div>

        <div class="def-label field-signupform-gender">
          <div id="signupform-gender" aria-required="true">
            <validation-provider rules="required" v-slot="{ errors }">
              <label
                  class="control-label"
                  :class="{error:errors[0]}"
              >{{ errors[0] ? langs.input_gender_error_require : langs.input_gender }}</label>
              <input
                  id="gender-0"
                  checked
                  type="radio"
                  :name="langs.input_gender"
                  value="1"
                  v-model="user.gender"
              />
              <label for="gender-0" class="def-radio">{{ langs.input_gender_male }}</label>
              <input
                  id="gender-1"
                  type="radio"
                  v-model="user.gender"
                  :name="langs.input_gender"
                  value="0"
              />
              <label for="gender-1" class="def-radio">{{ langs.input_gender_female }}</label>
            </validation-provider>
          </div>
        </div>
        <div class="def-label field-signupform-parent_code">
          <validation-provider v-slot="{ errors }">
            <img src="/uploads/static/info.png" style="display: inline-block" height="15px" width="15px" data-toggle="tooltip" data-placement="right" :title="langs.register_referral_info" />
            <label
                class="control-label"
                for="signupform-parent_code"
                :class="{error:errors[0]}"
            >{{ langs.input_referral }}</label>
            <input
                type="text"
                id="signupform-parent_code"
                class="form-control"
                :name="langs.input_referral"
                :placeholder="langs.input_referral"
                autocomplete="off"
                v-model="user.parent_code"
            />
          </validation-provider>
          <!-- <validation-provider
            :rules="{ required: { allowFalse: false }}"
            class="agreement"
            v-slot="{ errors }"
            v-if="user.parent_code"
          >
            <input
              type="checkbox"
              name="Agreement"
              id="referal-checkbox"
              v-model="referralAgreement"
            />
            <label :class="{error:errors[0]}" class="def-checkbox" for="referal-checkbox">
              <a target="_blank" href="/terms.pdf">
                {{errors[0] || `Referal haqqında müqaviləni oxudum və
                razılaşdım.*`}}
              </a>
            </label>
          </validation-provider>-->
        </div>
        <div class="password-el">
          <div class="def-label field-signupform-password required">
            <validation-provider rules="required" v-slot="{ errors }">
              <label
                  class="control-label"
                  for="signupform-password"
                  :class="{error:errors[0]}"
              >{{ errors[0] ? langs.input_password_error_require : langs.input_password }}</label>
              <input
                  type="password"
                  id="signupform-password"
                  class="form-control"
                  :name="langs.input_password"
                  placeholder="••••••••••••"
                  autocomplete="off"
                  aria-required="true"
                  minlength="8"
                  v-model="user.password"
              />
            </validation-provider>
          </div>
          <span class="control-password">
            <i class="fas fa-eye"></i>
          </span>
        </div>

        <div class="def-label field-register-checkbox required">
          <validation-provider :rules="{ required: { allowFalse: false }}" v-slot="{ errors }">
            <input
                type="checkbox"
                id="register-checkbox"
                :name="langs.input_agreement"
                v-model="user.agreement"
            />
            <label class="def-checkbox" for="register-checkbox">
              <a
                  target="_blank"
                  href="/uploads/static/terms_aze.pdf"
              >{{ `Üzvlük haqqında müqaviləni oxudum və razılaşdım.*` }}</a>
            </label>
            <p
                class="agreement_error"
                :class="{error:errors[0]}"
            >{{ errors[0] ? langs.input_agreement_error_require : langs.input_agreement }}</p>
          </validation-provider>
        </div>
        <div class="flex-between register-submit">
          <!--					<button :loading="btnLoading" type="submit" class="orange-button">Qeydiyyatdan keç</button>-->
          <vue-button-spinner
              :is-loading="btnLoading"
              :disabled="btnLoading"
              class="orange-button"
              :status="btnStatus">
            <span>Qeydiyyatdan keç</span>
          </vue-button-spinner>
          <button type="reset" class="reset" ref="myBtn">Reset</button>
        </div>
      </form>
    </ValidationObserver>
    <template v-if="image">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
              <div class="modal-header">
                <slot name="header">Numune</slot>
              </div>

              <div class="modal-body">
                <slot name="body">
                  <img :src="example" alt />
                </slot>
              </div>

              <div class="modal-footer">
                <slot name="footer">
                  <button class="modal-default-button" @click="image=!image">OK</button>
                </slot>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </template>
  </div>
</template>


<script>
import { extend, ValidationObserver, ValidationProvider } from 'vee-validate'
import VueButtonSpinner                                   from 'vue-button-spinner'
import { mask }                                           from 'vue-the-mask'
// import DatePicker from 'vue2-datepicker'
// import 'vue2-datepicker/index.css'
import vSelect                                            from 'vue-select'
import 'vue-select/dist/vue-select.css'
import Swal                                               from 'sweetalert2'

import * as rules         from 'vee-validate/dist/rules'
// import { messages as az } from 'vee-validate/dist/locale/az.json'
// import { messages as ru } from 'vee-validate/dist/locale/ru.json'
import { messages as en } from 'vee-validate/dist/locale/en.json'

Object.keys(rules)
      .forEach(rule => {
        extend(rule, {
          ...rules[rule], // copies rule configuration
          message: en[rule] // assign message
        })
      })

var searchInput = 'signupform-address'

$(document)
    .ready(function () {

        $('[data-toggle="tooltip"]').tooltip();

      $(window)
          .keydown(function (event) {
            if (event.keyCode === 13) {
              event.preventDefault()
              return false
            }
          })

      var autocomplete
      autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
        types                : ['geocode'],
        componentRestrictions: {
          country: 'AZE'
        }
      })
      /*$(document)
          .on('input', '#' + searchInput, function () {
            document.getElementById('address_label').style.color = 'red'

            document.getElementById('location_latitude').value  = ''
            document.getElementById('location_longitude').value = ''

            /!*document.getElementById('latitude_view').innerHTML  = ''
            document.getElementById('longitude_view').innerHTML = ''*!/
          })*/
      google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var near_place = autocomplete.getPlace()
        /*if (near_place.geometry) {
          document.getElementById('address_label').style.color = 'white'
        }*/
        setTimeout(() => {
          document.getElementById('location_latitude').value  = near_place.geometry.location.lat()
          document.getElementById('location_longitude').value = near_place.geometry.location.lng()

          /*document.getElementById('latitude_view').innerHTML  = near_place.geometry.location.lat()
          document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng()*/
        }, 10)
      })
    })

export default {
  components: {
    ValidationProvider,
    ValidationObserver,
    vSelect,
    VueButtonSpinner
  },
  props     : {
    myRoute: {
      type: String
    },
    myToken: {
      type: String
    },
    myYear : {
      type: String
    },
    cities : {
      type: Array
    },
    langs  : {
      type: Object
    }
  },
  data () {
    return {
      lang            : 'az',
      image           : false,
      // referralAgreement: false,
      cities2         : [
        { label: 'Baki', code: 1 },
        { label: 'Agcabedi', code: 2 },
        { label: 'Agdam', code: 3 },
        { label: 'Agdash', code: 4 },
        { label: 'Agstafa', code: 5 },
        { label: 'Agsu', code: 6 },
        { label: 'Astara', code: 7 },
        { label: 'Balaken', code: 8 },
        { label: 'Beylagan', code: 9 },
        { label: 'Barda', code: 10 },
        { label: 'Bilasuvar', code: 11 },
        { label: 'Calilabad', code: 12 },
        { label: 'Fuzuli', code: 13 },
        { label: 'Gadabay', code: 14 },
        { label: 'Ganja', code: 15 },
        { label: 'Goranboy', code: 16 },
        { label: 'Goychay', code: 17 },
        { label: 'Goytapa', code: 18 },
        { label: 'Hajikhabul', code: 19 },
        { label: 'Imishli', code: 20 },
        { label: 'Ismayilli', code: 21 },
        { label: 'Kurdamir', code: 22 },
        { label: 'Lerik', code: 23 },
        { label: 'Lankaran', code: 24 },
        { label: 'Masalli', code: 125 },
        { label: 'Mingachevir', code: 26 },
        { label: 'Naftalan', code: 27 },
        { label: 'Nakhchivan', code: 28 },
        { label: 'Neftchala', code: 29 },
        { label: 'Oguz', code: 30 },
        { label: 'Gakh', code: 31 },
        { label: 'Gazakh', code: 32 },
        { label: 'Gabala', code: 33 },
        { label: 'Guba', code: 34 },
        { label: 'Gusar', code: 35 },
        { label: 'Saatly', code: 36 },
        { label: 'Sabirabad', code: 37 },
        { label: 'Salyan', code: 38 },
        { label: 'Shabran', code: 39 },
        { label: 'Shaki', code: 40 },
        { label: 'Shamkir', code: 41 },
        { label: 'Shirvan', code: 42 },
        { label: 'Siyazan', code: 43 },
        { label: 'Sumgayit', code: 44 },
        { label: 'Tovuz', code: 45 },
        { label: 'Ucar', code: 46 },
        { label: 'Khacmaz', code: 47 },
        { label: 'Khirdalan', code: 48 },
        { label: 'Khizi', code: 49 },
        { label: 'Khudat', code: 50 },
        { label: 'Yevlakh', code: 51 },
        { label: 'Zagatala', code: 52 },
        { label: 'Zardab', code: 53 },
        { label: 'Shamaxi', code: 54 }
      ],
      inputErrors     : {
        Email          : {
          is: false
        },
        passport_number: {
          is: false
        },
        passport_fin   : {
          is: false
        },
        phone1         : {
          is: false
        },
        phone2         : {
          is: false
        }
      },
      user            : {
        name           : '',
        surname        : '',
        email          : '',
        phone1         : '',
        phone2         : '',
        birthday       : '',
        language       : '',
        city           : '',
        passport_series: '',
        passport_number: '',
        passport_fin   : '',
        gender         : '',
        parent_code    : '',
        password       : '',
        agreement      : '',
      },
      btnLoading      : false,
      btnStatus       : ''
    }
  },
  methods   : {
    onSubmit (valid) {
      this.btnLoading = true
      const _this     = this
      const formData  = new FormData()
      Object.keys(_this.user)
            .map(key => {
              return formData.append(key, _this.user[key])
            })
      formData.append('_token', _this.myToken)
      formData.append('address1', document.getElementById('signupform-address')
          .value)
      formData.append('location_longitude', document.getElementById('location_longitude')
          .value)
      formData.append('location_latitude', document.getElementById('location_latitude')
          .value)
      this.$refs.form.validate().then(success => {
        if (!success) {
          this.btnLoading = false
          this.btnStatus  = false //or error
          setTimeout(() => {
            this.btnStatus        = ''
            const elements        = document.getElementsByClassName('error')
            const requiredElement = elements[0]
            requiredElement.scrollIntoView({
              block   : 'center',
              behavior: 'smooth'
            })
          }, 500)
          return false
        }

        axios
            .post(this.myRoute, formData)
            .then(resp => {
              const response = resp.data
              // this.inputErrors = {}
              Object.keys(this.inputErrors)
                    .forEach(key => {
                      this.inputErrors[key].is = false
                    })
              if (response.case === 'success') {
                Swal.fire(response.title, response.content, response.case)
                Object.keys(_this.user)
                      .map(key => {
                        return (_this.user[key] = '')
                      })
                document.getElementById('signupform-address').value = ''
                document.getElementById('location_latitude').value  = ''
                document.getElementById('location_longitude').value = ''
                const elem                                          = _this.$refs.myBtn

                elem.click()
              } else {
                this.btnStatus = false
                if (response.type === 'validation') {
                  const content         = response.content
                  let validationMessage = ''
                  Object.keys(content)
                        .forEach(key => {
                          const value = content[key]
                          if (value.length !== 0) {
                            for (let i = 0; i < value.length; i++) {
                              validationMessage += value[i] + '\n'
                            }
                          }
                        })
                  Swal.fire('Validation error!', validationMessage, 'warning')
                } else if (response.type === 'exist') {
                  this.inputErrors[response.input].is      = true
                  this.inputErrors[response.input].content = response.content
                  Swal.fire(response.title, response.content, response.case)
                      .then(() => {
                        setTimeout(() => {
                          // const elements        = document.getElementsByName(response.input)
                          const elements = document.querySelector(`[myid=${response.input}]`)
                          // const requiredElement = elements[0]
                          elements.scrollIntoView({
                            block   : 'center',
                            behavior: 'smooth'
                          })
                        }, 500)
                      })
                } else {
                  Swal.fire(response.title, response.content, response.case)
                }
                // Object.keys(_this.user).map(key => {
                //   return (_this.user[key] = '')
                // })
                // const elem = _this.$refs.myBtn
                // elem.click()
              }
            })
            .catch(response => {
              console.error(response)
              this.btnStatus = false
            })
            .finally(() => {
              this.btnLoading = false
              setTimeout(() => {
                this.btnStatus = ''
              }, 500)
            })
      })
    },
    val () {
      const year = +this.user.birthday.slice(0, 4)
      const el   = document.getElementById('signupform-birthday')
      if (year > this.myYear) {
        el.setCustomValidity(this.langs.input_birthday_min_error)
      } else {
        el.setCustomValidity('')
      }
    },
    changeOnVoen () {
      if (this.user.passport_series === 'VOEN') {
        this.$refs.form.reset();
        this.user.passport_fin = 'VOEN'
      }
    },
  },
  computed  : {
    example () {
      switch (this.user.passport_series) {
        case 'AZE':
          return '/uploads/static/1.png'
        case 'AA':
          return '/uploads/static/2.png'
        case 'MYI':
          return '/uploads/static/3.png'
        case 'DYI':
          return '/uploads/static/4.png'
        case 'VOEN':
          return '/uploads/static/voen.jpg'
        default:
          return '/uploads/static/1.png'
      }
    },
    senedError () {
      switch (this.user.passport_series) {
        case 'AZE':
          return this.langs.input_passport_error_8
        case 'AA':
          return this.langs.input_passport_error_7
        case 'MYI':
          return this.langs.input_passport_error_7
        case 'DYI':
          return this.langs.input_passport_error_7
        case 'VOEN':
          return this.langs.input_passprot_voen_error
        default:
          return this.langs.input_passport_series_error_require
      }
    },
    finError () {
      switch (this.user.passport_series) {
        case 'AZE':
          return this.langs.input_passport_fin_error_7
        case 'AA':
          return this.langs.input_passport_fin_error_7
        case 'MYI':
          return this.langs.input_passport_fin_error_6
        case 'DYI':
          return this.langs.input_passport_fin_error_7
        case 'VOEN':
          return this.langs.input_passport_fin
        default:
          return 'SƏNƏDİN SERIASINI SEÇIN'
      }
    },
    senedLength () {
      switch (this.user.passport_series) {
        case 'AZE':
          return 8
        case 'AA':
          return 7
        case 'MYI':
          return 7
        case 'DYI':
          return 7
        case 'VOEN':
          return 10
        default:
          return null
      }
    },
    finLength () {
      switch (this.user.passport_series) {
        case 'AZE':
          return 7
        case 'AA':
          return 7
        case 'MYI':
          return 6
        case 'DYI':
          return 7
        case 'VOEN':
          return 4
        default:
          return null
      }
    }
  },
  watch     : {
    /*referralAgreement (val) {
      const _this = this
      if (!val) {
        _this.user.referal = ''
      }
    }*/
  },
  directives: {
    mask: mask
  },
  mounted () {

  }
}
</script>
