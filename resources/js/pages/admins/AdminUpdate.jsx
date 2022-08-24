import React, { useEffect, useState } from 'react'
import Form from 'react-bootstrap/Form'
import Button from 'react-bootstrap/Button'
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Swal from 'sweetalert2';
import { useNavigate, useParams } from 'react-router-dom'
import SideBar from '../../components/SideBar';
import Navbar from '../../components/Navbar';
import Footer from '../../components/Footer';
import apiClient from '../../services/Api';

export default function AdminUpdate() {
  const navigate = useNavigate();
  const { id } = useParams();
  const token = JSON.parse(localStorage.getItem('authInfo'));

  const [name, setName] = useState("")
  const [username, setUsername] = useState("")
  const [email, setEmail] = useState("")
  const [phone, setPhone] = useState("")
  const [roles, setRoles] = useState("")
  const [password, setPassword] = useState("")
  const [isOutside, setIsOutside] = useState("")
  const [status, setStatus] = useState("")
  const [validationError,setValidationError] = useState({})

  useEffect(() => {
    getByIdAdmin()
  }, [])
    console.log(password)
    const getByIdAdmin = async () => {
        await apiClient.get(`/api/admin/${id}`,{
            'headers':{
                "Authorization": `Bearer ${token.access_token}`
            }
        }).then(({data})=>{
            if (localStorage.getItem('loggedIn')) {
                const { name, username, email, phone, roles, is_outside, status } = data.data
                setName(name)
                setUsername(username)
                setEmail(email)
                setPhone(phone)
                setRoles(roles)
                setIsOutside(is_outside)
                setStatus(status)
            }
        }).catch(({response:{data}})=>{
            Swal.fire({
            text:data.message,
            icon:"error"
            })
        })
  }

  const updateAdmin = async (e) => {
        e.preventDefault();

        const formData = new FormData()
        formData.append('_method', 'PATCH');
        formData.append('id', id)
        formData.append('name', name)
        formData.append('username', username)
        formData.append('email', email)
        password && formData.append('password', password)
        formData.append('phone', phone)
        formData.append('roles', roles)
        formData.append('is_outside', isOutside)
        formData.append('status', status)

        if (localStorage.getItem('loggedIn')) {
            await apiClient.post(`/api/admin/${id}`, formData,{
                'headers':{
                    "Authorization": `Bearer ${token.access_token}`
                }
            }).then(({data})=>{
                Swal.fire({
                icon:"success",
                // text:data.message
                text:"Məlumatlar yeniləndi"
                })
                navigate("/admins")
            }).catch(({response})=>{
                if(response.status===422){
                setValidationError(response.data.errors)
                }else{
                Swal.fire({
                    text:response.data.message,
                    icon:"error"
                })
                }
            })
        }
  }


  function genPassword() {
    let phones = document.getElementById("phone");
    var chars = "!@#$%";
    var passwordLength = 2;
    var passwords = "";
    passwords += document.getElementById("username").value;
    passwords += phones.value.substr(phones.value.length - 4);

    for (var i = 0; i < passwordLength; i++) {
        var randomNumber = Math.floor(Math.random() * chars.length);
        passwords += chars.substring(randomNumber, randomNumber + 1);
    }
    setPassword(passwords);
}


  return (
    <div>
        <div className="layout-wrapper layout-content-navbar">
            <div className="layout-container">
                <SideBar />
                <div className="layout-page">
                    <Navbar />
                    <div className="content-wrapper">
                        <div className="container-xxl flex-grow-1 container-p-y">
                            <h4 className="fw-bold py-3 mb-4"><a href="{{ route('admins.index') }}"><span className="text-muted fw-light">Adminlər /</span></a>Yeni Admin</h4>
                            <div className="row">
                                <div className="col-md-12">
                                    <div className="card mb-4">
                                    <h5 className="card-header">Yeni Admin</h5>
                                    <div className="card-body">
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
                                        <div>
                                        <Form onSubmit={updateAdmin}>

                                            <Row> 
                                                <Col>
                                                    <Form.Group controlId="Name">
                                                        <Form.Label>Ad Soyad</Form.Label>
                                                        <Form.Control type="text"value={name} onChange={(event)=>{
                                                                    setName(event.target.value)
                                                                }} />
                                                    </Form.Group>
                                                </Col>  
                                            </Row>
                                            <Row className="my-3"> 
                                                <Col>
                                                    <Form.Group controlId="username">
                                                        <Form.Label>İstifadəçi Adı</Form.Label>
                                                        <Form.Control type="text" value={username} onChange={(event)=>{
                                                                    setUsername(event.target.value)
                                                                }}/>
                                                    </Form.Group>
                                                </Col>  
                                            </Row>
                                            <Row className="my-3"> 
                                                <Col>
                                                    <Form.Group controlId="Email">
                                                        <Form.Label>Email Address</Form.Label>
                                                        <Form.Control type="email" value={email} onChange={(event)=>{
                                                                    setEmail(event.target.value)
                                                                }}/>
                                                    </Form.Group>
                                                </Col>  
                                            </Row>
                                            <Row className="my-3"> 
                                                <Col>
                                                    <Form.Group controlId="phone">
                                                        <Form.Label>Mobil Nömrə</Form.Label>
                                                        <Form.Control type="text" value={phone} onChange={(event)=>{
                                                                    setPhone(event.target.value)
                                                                }}/>
                                                    </Form.Group>
                                                </Col>  
                                            </Row>
                                            <Row className="my-3">
                                                <Col>
                                                    <Form.Group controlId="Role">
                                                        <Form.Label>İSTİFADƏÇI ROLU</Form.Label>
                                                        <Form.Select value={roles} onChange={(e) => setRoles(e.target.value)}>
                                                            <option>Seçin</option>
                                                            <option value="superadmin">Superadmin</option>
                                                        </Form.Select>
                                                    </Form.Group>
                                                </Col>
                                            </Row>
                                            <Row className="my-3"> 
                                                <Col>
                                                    <Form.Group controlId="password" >
                                                        <Form.Label as={Col}>Şifrə</Form.Label>
                                                        <Row>
                                                        <Col md={9}>
                                                            <Form.Control type="password" value={password} onChange={(event)=>{
                                                                    setPassword(event.target.value)
                                                                }}/>
                                                        </Col>
                                                        <Col>
                                                            <div id="button" className="col-12 btn btn-primary" onClick={genPassword} >Generate</div>
                                                        </Col>
                                                        </Row>
                                                    </Form.Group>
                                                </Col>
                                            </Row>
                                            <Row className="my-3">
                                                <Col>
                                                    <Form.Group controlId="isOutside">
                                                        <Form.Label>Kənardan giriş</Form.Label>
                                                        <Form.Select value={isOutside} onChange={(e) => setIsOutside(e.target.value)}>
                                                            <option>Seçin</option>
                                                            <option value="active">Aktiv</option>
                                                            <option value="deactive">Deaktiv</option>
                                                        </Form.Select>
                                                    </Form.Group>
                                                </Col>
                                            </Row>
                                            <Row className="my-3">
                                                <Col>
                                                    <Form.Group controlId="Status">
                                                        <Form.Label>Status</Form.Label>
                                                        <Form.Select value={status} onChange={(e) => setStatus(e.target.value)}>
                                                            <option>Seçin</option>
                                                            <option value="active">Aktiv</option>
                                                            <option value="deactive">Deaktiv</option>
                                                        </Form.Select>
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
                        <Footer />
                    <div className="content-backdrop fade"></div>
                </div>
            </div>
          </div>
          <div className="layout-overlay layout-menu-toggle"></div>
        </div>
    </div>
  )
}
