class UserModel {
  final String email, password, fName, lName, facultyOrigin, erasmusFaculty;
  String uid = "";

  UserModel(this.email, this.password, this.fName, this.lName,
      this.facultyOrigin, this.erasmusFaculty);

  UserModel.fromJson(Map<String, dynamic> json)
      : email = json['email'],
        password = json['password'],
        fName = json['fName'],
        lName = json['lName'],
        facultyOrigin = json['facultyOrigin'],
        erasmusFaculty = json['erasmusFaculty'];

  Map<String, dynamic> toJson() => {
    'firstname': fName,
    'lastname': lName,
    'facultyOrigin': facultyOrigin,
    'erasmusFaculty': erasmusFaculty
  };
}
