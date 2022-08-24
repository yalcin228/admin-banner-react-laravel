import React, {useState} from 'react'
import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button'
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import { useNavigate } from 'react-router-dom'
import { Navigate } from "react-router-dom";
import apiClient from '../services/Api';

export default function Login({login}) {
    const navigate = useNavigate();
    const [username, setUsername] = useState("");
    const [password, setPassword] = useState("");
    const [validationError,setValidationError] = useState({})
    
    if (localStorage.getItem('loggedIn')) {
        return <Navigate replace to="/admins" />
    }
    

    const handleSubmit = async (e) => {
        e.preventDefault();
        const formData = new FormData()

        formData.append('username', username)
        formData.append('password', password)


        apiClient.get('/sanctum/csrf-cookie')
            .then(response => {
                apiClient.post(`/api/login`, formData).then(response => {
                    if (response?.status === 200) {
                        login()
                        localStorage.setItem('authInfo',JSON.stringify(response.data))
                        navigate("/admins")
                    } else{
                        setValidationError(response.data.errors)
                    }
                }).catch(e => {
                    setValidationError(e.response.data.errors)
                });
            });
      
    };



    return (
        <div>
            <div className="container-xxl">
                <div className="authentication-wrapper authentication-basic container-p-y">
                    <div className="authentication-inner">
                        <div className="card">
                            <div className="card-body">
                                <div className="app-brand justify-content-center">
                                    <a href="index.html" className="app-brand-link gap-2">
                            <span className="app-brand-logo demo">
                            
                            </span>
                                        <span className="app-brand-text demo text-body fw-bolder">Admin-Banner</span>
                                    </a>
                                </div>
                                <h4 className="mb-2">Admin Panele Xoş Gəlmisiniz! 👋</h4>
                                <p className="mb-4">Zəhmət olmasa hesabınıza daxil olun</p>
                                {
                                    Object.keys(validationError).length > 0 && (
                                        <div className='alert alert-danger'>
                                            <ul className="mb-0">
                                                {
                                                    Object.entries(validationError).map(([key, value])=>(
                                                        <li key={key}>{value}</li>   
                                                    ))
                                                }
                                            </ul>
                                        </div>
                                    )
                                }
                                <Form onSubmit={handleSubmit}>
                                    <Row> 
                                        <Col>
                                            <Form.Group controlId="name">
                                                <Form.Label>İstİfadəçİ adı</Form.Label>
                                                <Form.Control type="text"  value={username} onChange={(event)=>{
                                                                    setUsername(event.target.value)
                                                                }}/>
                                            </Form.Group>
                                        </Col>  
                                    </Row>
                            
                                    <Row className="my-3"> 
                                        <Col>
                                            <Form.Group controlId="password" >
                                                <Form.Label>Şİfrə</Form.Label>
                                                <Form.Control type="password"  value={password} onChange={(event)=>{
                                                                    setPassword(event.target.value)
                                                                }}/>
                                            </Form.Group>
                                        </Col>
                                    </Row>
                                
                                    
                                    <Button variant="primary" className="mt-2" size="lg" block="block" type="submit">
                                        Əlave et
                                    </Button>
                                </Form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
