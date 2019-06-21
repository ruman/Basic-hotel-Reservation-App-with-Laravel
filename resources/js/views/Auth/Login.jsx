import React, { Component } from "react";
import { Button } from "reactstrap";

class Login extends React.Component {
    constructor(props) {
        super(props);
        this.processSubmit = this.processSubmit.bind(this);
        this.state = {
        	formControl: {
        		email: 'admin@admin.com',
        		password: 'admin123'
        	}
        }
    };
    processSubmit(event) {
        event.preventDefault();
        var apiBaseUrl = "/admin/Login";
        var self = this;
        var formdata = {
            "email": event.target.email.value,
            "password": event.target.password.value
        }
        console.log(formdata);
        axios.post(apiBaseUrl, formdata)
            .then(function(response) {
                console.log(response);
                if (response.data.code == 200) {
                    console.log("Login successfull");
                    /*var uploadScreen = [];
                    uploadScreen.push(<UploadScreen appContext={self.props.appContext} />)
                    self.props.appContext.setState({ loginPage: [], uploadScreen: uploadScreen })*/
                } else if (response.data.code == 204) {
                    console.log("Username password do not match");
                    alert("username password do not match")
                } else {
                    console.log("Username does not exists");
                    alert("Username does not exist");
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    }
    render() {
        const { handleSubmit, submitting } = this.props;
        const { formControl } = this.state;
        return (
            <div className="container">
			  <div className="pagelogin">
			  	<div className="row justify-content-center">
			  		<div className="col-sm-6">
			  			<div className="card">
			  				<div className="card-header"><h4>Login</h4></div>
			  				<div className="card-body">
			  					<form role="form" method="POST" onSubmit={this.processSubmit}>
			  						<div className="form-group"><input className="form-control" name="email" type="email" value={formControl.email} /></div>
			  						<div className="form-group"><input className="form-control" name="password" type="password"  value={formControl.password} /></div>
			  						<div className="form-group"><Button type="submit" color="primary">Login</Button></div>
			  					</form>
			  				</div>
			  			</div>
			  		</div>
			  	</div>
			  </div>
			</div>
        );
    }
}

export default Login;
