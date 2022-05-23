import 'package:erasmus_helper/blocs/profile_bloc/profile_event.dart';
import 'package:erasmus_helper/blocs/profile_bloc/profile_state.dart';
import 'package:erasmus_helper/models/tag.dart';
import 'package:erasmus_helper/models/user.dart';
import 'package:erasmus_helper/services/faculty_service.dart';
import 'package:erasmus_helper/services/tag_service.dart';
import 'package:erasmus_helper/services/user_service.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

class ProfileBloc extends Bloc<ProfileEvent, ProfileState> {
  List<Tag> tags = [];

  ProfileBloc() : super(ProfileInitialState()) {
    on<FetchProfileEvent>(_mapFetchProfileEventToState);
    on<EditProfileEvent>((event, emit) => emit(ProfileEditingState(tags)));
    on<SubmitProfileEvent>(_mapSubmitProfileEventToState);
  }

  @override
  void onTransition(Transition<ProfileEvent, ProfileState> transition) {
    print(transition);
    super.onTransition(transition);
  }

  Future<void> _mapFetchProfileEventToState(ProfileEvent event, Emitter<ProfileState> emit) async {
    emit(ProfileFetchingState());
    UserModel? profile = await UserService().getUserProfile();
    if (profile != null) {
      profile.facultyOriginName =
          await FacultyService.getFacultyById(profile.facultyOrigin);
      tags = await TagService.getTags();
      emit(ProfileFetchedState(profile));
    } else {
      emit(ProfileErrorState());
    }
  }

  Future<void> _mapSubmitProfileEventToState(SubmitProfileEvent event, Emitter<ProfileState> emit) async {
    UserService.updateUserProfile(event.profile);
    await _mapFetchProfileEventToState(event, emit);
  }
}
