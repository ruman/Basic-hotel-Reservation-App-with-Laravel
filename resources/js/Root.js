import React from "react";
import ReactDOM from "react-dom";
import { createBrowserHistory } from "history";
import { Router, Route, Switch, Redirect } from "react-router-dom";
/*import { createStore, combineReducers } from "redux";
import {
	reducer as formReducer,
	reduxForm,
	Field
} from "redux-form";*/

// core components
import FrontEnd from "./layouts/Frontend";
import Login from "./views/Auth/Login";

const hist = createBrowserHistory();

ReactDOM.render(
  <Router history={hist}>
    <Switch>
      <Route exact path="/" component={FrontEnd} />
      <Route path="/login" component={Login} />
      <Route path="/register" component={Register} />
      <Route component={Page404} />
    </Switch>
  </Router>,
  document.getElementById("root")
);

function Register(){
	return <h2>Register Page</h2>;
}

function Page404(){
	return <h1 className="error-title error danger">Page Not Found!!!</h1>
}