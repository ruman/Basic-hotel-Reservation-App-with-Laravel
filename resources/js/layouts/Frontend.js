/* eslint-disable */
import React from "react";
import PropTypes from "prop-types";
import { Switch, Route, Redirect, Link } from "react-router-dom";

import FrontendView from "../views/Frontend/Frontend";

class Frontend extends React.Component {
  constructor(props) {
    super(props);
    // this.handleSubmit = this.handleSubmit.bind(this);    
    this.state = {
      navPage: 'login'
    }   
  };
  currentPage(){
    return 'login';
  };
  render() {
    const { classes, ...rest } = this.props;
    const { navPage } = this.state;
    const navs = [
      {id:'login', title: 'Login'},
      {id:'register', title: 'Register'},
      {id:'forgot', title: 'Forgot'}
    ];
    return (
      <FrontendView />
    );
  }
}

export default Frontend;
