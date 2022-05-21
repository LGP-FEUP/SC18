import 'package:erasmus_helper/blocs/profile_bloc/profile_event.dart';
import 'package:erasmus_helper/blocs/profile_bloc/profile_state.dart';
import 'package:erasmus_helper/models/user.dart';
import 'package:erasmus_helper/services/user_service.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

class ProfileBloc extends Bloc<ProfileEvent, ProfileState> {
  ProfileBloc() : super(ProfileInitialState()) {
    on<FetchProfileEvent>(_mapFetchProfileEventToState);
    on<EditProfileEvent>((event, emit) => emit(ProfileEditingState()));
    on<SubmitProfileEvent>(_mapSubmitProfileEventToState);
  }

  @override
  void onTransition(Transition<ProfileEvent, ProfileState> transition) {
    print(transition);
    super.onTransition(transition);
  }

  Future<void> _mapFetchProfileEventToState(
      ProfileEvent event, Emitter<ProfileState> emit) async {
    emit(ProfileFetchingState());
    UserModel? profile = await UserService().getUserProfile();
    if (profile != null) {
      emit(ProfileFetchedState(profile));
    } else {
      emit(ProfileErrorState());
    }
  }

  Future<void> _mapSubmitProfileEventToState(
      SubmitProfileEvent event, Emitter<ProfileState> emit) async {
    UserService.updateUserProfile(event.profile);
    emit(ProfileFetchedState(event.profile));
  }
}
