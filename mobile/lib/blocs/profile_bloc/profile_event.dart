import 'package:erasmus_helper/models/user.dart';

class ProfileEvent {}

class FetchProfileEvent extends ProfileEvent {}

class EditProfileEvent extends ProfileEvent {}

class SubmitProfileEvent extends ProfileEvent {
  UserModel profile;

  SubmitProfileEvent(this.profile);
}
