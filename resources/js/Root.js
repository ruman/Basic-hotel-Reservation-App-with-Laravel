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

const hist = createBrowserHistory();

ReactDOM.render(
  <Router history={hist}>
    <Switch>
      <Route exact path="/" component={FrontEnd} />
      <Route component={Page404} />
    </Switch>
  </Router>,
  document.getElementById("root")
);

function Page404(){
	return <div className="container">
          <div className="row">
            <div className="col-sm-12">
              <h1 className="error-title error-danger">Page Not Found!!!</h1>
            </div>
          </div>
        </div>
}