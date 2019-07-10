/* eslint-disable */
import axios from 'axios';
import React from "react";
import ReactDOM from 'react-dom'
import PropTypes from "prop-types";
import { Switch, Route, Redirect, Link } from "react-router-dom";
import { Button, Modal, ModalHeader, ModalBody, ModalFooter, Input, Label, Form, FormGroup } from 'reactstrap';

import { DatePicker, RangeDatePicker } from '@y0c/react-datepicker';

import '@y0c/react-datepicker/assets/styles/calendar.scss';


// Validation
// import useValitedForm from 'react-valida-hook'
import BookingForm from '../views/Frontend/BookingForm';
// import FrontendView from "../views/Frontend/Frontend";

class Frontend extends React.Component {
  constructor(props) {
    super(props);
    // this.handleSubmit = this.handleSubmit.bind(this);    
    this.state = {
      room_types: [],
      roomType: '',
      toDate: '',
      fromDate: '',
      requesting:false,
      errors: false,
      hoteldata: false,
      roomdetails: false,
      modal:false,
      country: '',
      hotel_id:'',
      room_id:'',
      first_name:'',
      last_name:'',
      address:'',
      city:'',
      state:'',
      phone:'',
      fax: '',
      email:''
    }   
  };

  componentDidMount () {
    fetch('/api/v1/room_types')
        .then(response => {
            return response.json();
        })
        .then(room_types => {
            this.setState({ room_types });
        });
  }

  renderRoomTypes() {
    // console.log(this.state.room_types);
     return this.state.room_types.map((roomType, key) => {
        return (
            <option value={roomType.id} key={key}>
                { roomType.name } 
            </option>      
        );
    }) 
  }

  selectCountry(country) {
    this.setState({country})
    /*return countryList.map((country, key) => {
      return (
          <option value={country.code}>
              { country.name } 
          </option>      
      );
    })*/
  }
  
  showErrors() {
    return Object.keys(this.state.errors).map((keyName, i) => {
      return (
        <li className="list-group-item" key={keyName}><strong>{this.state.errors[keyName]}</strong></li>
      )
    });
  }

  onChange = (fromDate, toDate) => {
    if(fromDate)
      this.setState({fromDate})
    if(toDate)
      this.setState({toDate})
  }

  setRoomType = (event) => {
    this.setState({ 'roomType':event.target.value });
  }

  checkAvailability = () => {
    let errors = {};
    this.setState({requesting:true, hoteldata:false, roomdetails:false});
    if(!this.state.fromDate){
      Object.assign(errors, {'checkin': 'Please select Check-in Date'});
    }
    if(!this.state.toDate){
      Object.assign(errors, {'checkout': 'Please select Check-out Date'});
    }
    if(!this.state.roomType){
      Object.assign(errors, {'roomtype': 'Please select roomType'});
    }
    if(Object.keys(errors).length){
      this.setState({errors: errors});
    }else {
      let post = {
         'from': this.state.fromDate,
         'to': this.state.toDate,
         'roomtype': this.state.roomType,
      }
      axios.post('/api/v1/getrooms', post)
      .then(response => {
        // redirect to the homepage
        if(response.status == 200){
          let data = response.data;
          if(data.success){
            this.setState({hoteldata:data.result});
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

  loadRoomDetails = (key) => {
    this.setState({roomdetails: [this.state.hoteldata[key]]});
  }

  displayRooms() {
    return this.state.hoteldata.map((data, i) => {
      return (
        <li className="list-group-item" onClick={
                () =>this.loadRoomDetails(i)} data-id={i} key={data.id} >
          Room Name: <strong>{data.room_name}</strong><br/>
          Rate: <strong>$<span>{data.rate}</span></strong>
        </li>
      )
    });
  }

  displayRoomDetails(){
    return this.state.roomdetails.map((data, i) => {
      return (
        <li className="list-group-item" key={data.id} >
          Hotel Name: <strong>{data.hotel_name}</strong><br/>
          Room Name: <strong>{data.room_name}</strong><br/>
          Rate: <strong>$<span>{data.rate}</span></strong>
        </li>
      )
    });
  }

  showbookingform = () => {
    let roomdetails = this.state.roomdetails;
    this.setState({hotel_id:this.state.roomdetails[0].hotel_id, 'room_id':this.state.roomdetails[0].room_id });
    this.setState({modal:true});
  }

  closeform = () => {
    this.setState({modal:false});
  }

  makeReservation = () => {
    let reservationdata = {
      hotel_id: this.state.roomdetails[0].hotel_id,
      room_id: this.state.roomdetails[0].room_id,
      country: this.state.country
    }
    console.log(reservationdata);
  }

  formviewStatus = (event) => {
    event.preventDefault();
    if(event.target.dataset.showform == 'close'){
      this.setState({modal:false})
    }
  }

  clearForm = () => {
    console.log('hrer')
    this.setState({
      toDate: '',
      fromDate: '',
      errors: false,
      hoteldata: false,
      roomdetails: false,
      modal:false,
      hotel_id:'',
      room_id:'',
      first_name:'',
      last_name:'',
      address:'',
      city:'',
      state:'',
      phone:'',
      fax: '',
      email:''
    })
  }

  render() {
    const { classes, ...rest } = this.props;
    const { room_types, errors, hoteldata, roomdetails, country, hotel_id, room_id, fromDate, toDate } = this.state;
    // const { formData, validation, validateForm, getData } = formValidation
    // console.log(validation);
    return (
      <div className="pageContent">
        <div className="container">
          {errors ? (
          <div className="row justify-content-center">
            <div className="col-sm-6"><div className="alert alert-danger">
                <ul className="list-group list-group-flush">
                  {this.showErrors()}
                </ul>
            </div></div>
          </div>
          ) : null }
            <div className="row justify-content-center">
              <div className="col-sm-4">
                 <div className="card">
                   <div className="card-header"><h4>Booking Form</h4></div>
                   <div className="card-body">
                     <div className="form-group">
                       <label className="control-label">Please Select your dates: </label>
                       <div className="clearfix">
                          <RangeDatePicker onChange={this.onChange}/>
                       </div>
                       <div className="form-group">
                          <label className="control-label">Please Select your dates: </label>
                          <div className="clearfix">
                            <select id="room_type" name="room_type" className="custom-select" onChange={this.setRoomType}>
                              <option>Please Select Room Type</option>
                              {this.renderRoomTypes()}
                            </select>
                          </div>
                       </div>
                       <div className="form-group">
                         <button onClick={this.checkAvailability} className="btn btn-success float-right">Check Availability</button>
                       </div>
                     </div>
                   </div>
                 </div>
              </div>
              {hoteldata ? (
                <div className="col-sm-4">
                  <ul className="list-group list-group-flush clickable">
                    {this.displayRooms()}
                  </ul>
                </div>
                ) : null
              }
              {roomdetails ? (
                <div className="col-sm-4">
                  <ul className="list-group list-group-flush">
                    {this.displayRoomDetails()}
                  </ul>
                  <button className="btn btn-primary btn-small" onClick={this.showbookingform}>Book Now</button>
                </div>
                ) : null
              }
            </div>
        </div>
        <Modal isOpen={this.state.modal} className={this.props.className} backdrop="static">
          <BookingForm formstatus={this.formviewStatus} hotelId={hotel_id} roomId={room_id} checkIn={fromDate} checkOut={toDate} clearForm={this.clearForm} />
        </Modal>
        <button id="clearForm" className="hidden clearform" onClick={this.clearForm} />
      </div>
    );
  }
}

export default Frontend;
