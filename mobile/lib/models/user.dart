class UserModel {
  final String email, password, fName, lName, faculty;
  String uid = "";

  UserModel(this.email, this.password, this.fName, this.lName, this.faculty);

  Map<String,String> getInfo() {
    return {
      "firstName": fName,
      "lastName": lName,
      "faculty_origin_id": faculty
    };
  }
}