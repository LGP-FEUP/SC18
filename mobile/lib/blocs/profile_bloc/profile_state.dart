import 'package:erasmus_helper/models/user.dart';

import '../../models/tag.dart';

class ProfileState {}

class ProfileInitialState extends ProfileState {}

class ProfileFetchingState extends ProfileState {}

class ProfileFetchedState extends ProfileState {
  UserModel profile;

  ProfileFetchedState(this.profile);
}

class ProfileErrorState extends ProfileState {}

class ProfileEditingState extends ProfileState {
  List<Tag> tags;

  ProfileEditingState(this.tags);
}
