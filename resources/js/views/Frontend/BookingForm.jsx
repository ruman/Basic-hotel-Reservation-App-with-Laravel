import React, { useState } from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios';
import useValitedForm from 'react-valida-hook'
import { Button, Modal, ModalHeader, ModalBody, ModalFooter, Input, Label, Form, FormGroup } from 'reactstrap';


import { CountryDropdown, RegionDropdown } from 'react-country-region-selector';

const initialState = {
  first_name: '',
  last_name: '',
  email: '',
  address: '',
  city: '',
  phone: '',
  fax: '',
}

const validations = [
  {
    name: 'first_name',
    type: 'required',
    stateMap: 'first_name'
  },
  {
    name: 'last_name',
    type: 'required',
    stateMap: 'last_name'
  },
  {
    name: 'email',
    type: 'required',
    stateMap: 'email'
  },
  {
    name: 'email',
    type: 'isEmail',
    stateMap: 'email'
  },
  {
    name: 'address',
    type: 'required',
    stateMap: 'address'
  },
  {
    name: 'city',
    type: 'required',
    stateMap: 'city'
  },
  {
    name: 'phone',
    type: 'required',
    stateMap: 'phone'
  },
  {
    name: 'fax',
    type: 'required',
    stateMap: 'fax'
  }
]

function BookingForm (props) {
  const [formData, validation, validateForm, getData] = useValitedForm(initialState, validations)
  const [countrycode, setCountry] = useState('')
  const [validcountry, setCountryValid] = useState(false)
  const submit = (event) => {
    event.preventDefault()
    const valid = validateForm()
    if(valid){
      let data = getData(), error = false;
      if(!props.hotelId){
        error = true;
        alert('Missing Hotel Information. Please Reload page');
      }
      if(!props.roomId){
        error = true;
        alert('Invalid Room Information. Please Reload page');
      }
      if(!props.checkIn){
        error = true;
        alert('Invalid Check-in Date. Please Reload page');
      }
      if(!props.checkOut){
        error = true;
        alert('Invalid Check-out Date. Please Reload page');
      }
      if(countrycode){
        setCountryValid(false);
      }else {
        error = true;
        setCountryValid(true);
        alert('Please Select Country');
      }
      if(!error){
        data.hotel_id = props.hotelId;
        data.room_id = props.roomId;
        data.check_in = props.checkIn;
        data.check_out = props.checkOut;
        data.country = countrycode;
        axios.post('/api/v1/makereservation', data)
        .then(response => {
          // redirect to the homepage
          if(response.status == 200){
            let data = response.data;
            if(data.success){
              alert(data.message);
              props.clearForm();
              /*var elef = document.getElementById('clearForm');
              if(typeof elef.click == 'function') {
                elef.click()
              } else if(typeof elef.onclick == 'function') {
                elef.onclick()
              }*/
            }else {
              alert(data.message);
            }
          }else {
            alert('failed to process');
          }
        })
        .catch(error => {
          console.log(error);
        })
      }
    }

  }
  /*const selectCountry = (country) => {
    // formData.country.input = country;
    setCountry(country);
    formData.country = country;
    return countryList.map((country, key) => {
      return (
          <option value={country.code}>
              { country.name } 
          </option>      
      );
    })
  }*/
  return (
    <div>
        <form noValidate={true} onSubmit={submit}>
        <ModalHeader>Make Reservation</ModalHeader>
        <ModalBody>
          <FormGroup>
            <label htmlFor='first-name' className="control-label">First name:</label>
            <input name='first_name' id='first-name' { ...formData.first_name.input }  className={validation.errors.first_name.join('') ? ( 
                'form-control is-invalid' ) : ( 'form-control' )
              } />

              {validation.errors.first_name.join('') ? ( 
                <div className='invalid-feedback'>
                  { validation.errors.first_name.join(', ')}
                </div>
              ) : null }
          </FormGroup>
          <FormGroup>
            <label htmlFor='last-name' className="control-label">Last name:</label>
            <input name='last_name' id='last-name' { ...formData.last_name.input } className={validation.errors.last_name.join('') ? ( 
                'form-control is-invalid' ) : ( 'form-control' )
              } />
              {validation.errors.last_name.join('') ? ( 
                <div className='invalid-feedback'>
                  { validation.errors.last_name.join(', ')}
                </div>
              ) : null }
          </FormGroup>
          <FormGroup>
            <label htmlFor='address' className="control-label">Address:</label>
            <input name='address' id='address' { ...formData.address.input } className={validation.errors.address.join('') ? ( 
                'form-control is-invalid' ) : ( 'form-control' )
              } />
              {validation.errors.address.join('') ? ( 
                <div className='invalid-feedback'>
                  { validation.errors.address.join(', ')}
                </div>
              ) : null }
          </FormGroup>
          <FormGroup>
            <label htmlFor='email' className="control-label">Email:</label>
            <input name='email' id='email' { ...formData.email.input }  className={validation.errors.email.join('') ? ( 
                'form-control is-invalid' ) : ( 'form-control' )
              } />
              {validation.errors.email.join('') ? ( 
                <div className='invalid-feedback'>
                  { validation.errors.email.join(', ')}
                </div>
              ) : null }
          </FormGroup>
          <FormGroup>
            <label htmlFor='city-name' className="control-label">City:</label>
            <input name='city' id='city-name' { ...formData.city.input } className={validation.errors.city.join('') ? ( 
                'form-control is-invalid' ) : ( 'form-control' )
              } />
              {validation.errors.city.join('') ? ( 
                <div className='invalid-feedback'>
                  { validation.errors.city.join(', ')}
                </div>
              ) : null }
          </FormGroup>
          <FormGroup>
            <label htmlFor='email' className="control-label">Country:</label>
            <CountryDropdown valueType="short" value={countrycode} onChange={
              (val) => setCountry(val)
              } classes={ validcountry ? ( 'custom-select is-invalid' ) : ('custom-select') } />
          </FormGroup>
          <FormGroup>
            <label htmlFor='phone-name' className="control-label">Phone:</label>
            <input name='phone' id='phone-name' { ...formData.phone.input } className={validation.errors.phone.join('') ? ( 
                'form-control is-invalid' ) : ( 'form-control' )
              } />
              {validation.errors.phone.join('') ? ( 
                <div className='invalid-feedback'>
                  { validation.errors.city.join(', ')}
                </div>
              ) : null }
          </FormGroup>
          <FormGroup>
            <label htmlFor='fax-name' className="control-label">Fax:</label>
            <input name='fax' id='fax-name' { ...formData.fax.input } className={validation.errors.fax.join('') ? ( 
                'form-control is-invalid' ) : ( 'form-control' )
              } />
              {validation.errors.fax.join('') ? ( 
                <div className='invalid-feedback'>
                  { validation.errors.fax.join(', ')}
                </div>
              ) : null }
          </FormGroup>
        </ModalBody>
        <ModalFooter>
          <Button color="primary" type="submit">Book Now</Button>{' '}
          <Button id="closemodal" color="secondary" onClick={props.formstatus} data-showform="close">Cancel</Button>
        </ModalFooter>
      </form>
    </div>
  )
}

export default BookingForm;