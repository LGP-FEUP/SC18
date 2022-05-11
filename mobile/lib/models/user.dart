import 'package:erasmus_helper/models/date.dart';

class UserModel {
  final String email, password, fName, lName, facultyOrigin, erasmusFaculty;
  late DateModel birthdate;
  String uid = "";

  UserModel(this.email, this.password, this.fName, this.lName,
      this.facultyOrigin, this.erasmusFaculty, String birthdate){
    this.birthdate = DateModel(birthdate);
  }

  UserModel.fromJson(Map<String, dynamic> json)
      : email = json['email'],
        password = json['password'],
        fName = json['fName'],
        lName = json['lName'],
        facultyOrigin = json['facultyOrigin'],
        erasmusFaculty = json['erasmusFaculty'];

  Map<String, dynamic> toJson() => {
    'id': uid,
    'firstname': fName,
    'lastname': lName,
    'faculty_origin_id': facultyOrigin,
    'faculty_arriving_id': erasmusFaculty,
    "date_of_birth": birthdate.toJson(),
    "validation_level": "1"
  };
}
